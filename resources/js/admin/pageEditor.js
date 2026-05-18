import tinymce from 'tinymce/tinymce';

function buildEmptyContent(fields = []) {
    const content = {}
    fields.forEach(field => {
        if (field.type === 'gallery' || field.type === 'repeater') {
            content[field.name] = []
        } else {
            content[field.name] = null
        }
    })
    return content
}

export default function pageEditor(initialBlocks = [], registry = {}) {
    return {
        registry,
        blocks: (initialBlocks ?? []).map(block => ({
            ...block,
            _key: crypto.randomUUID(),
            content: block.content ?? buildEmptyContent(
                registry[block.component]?.fields ?? []
            )
        })),
        selectedComponent: null,

        addBlock() {
            const componentName = (this.selectedComponent || '').trim()
            if (!componentName) return

            const component = this.registry[componentName]
            if (!component) {
                console.warn('Component not found in registry:', componentName, this.registry)
                return
            }

            this.blocks.push({
                id: null,
                _key: crypto.randomUUID(),
                component: componentName,
                content: buildEmptyContent(component.fields)
            })
        },

        removeBlock(index) {
            const block = this.blocks[index]
            document.querySelectorAll(`[data-key="${block._key}"] textarea`).forEach(el => {
                if (el.id) tinymce.get(el.id)?.remove()
            })
            this.blocks = this.blocks.filter((_, i) => i !== index)
        },

        syncBlocksOrder() {
            const keys = [...document.querySelectorAll('#blocks-container [data-key]')]
                .map(el => el.dataset.key)

            this.blocks = keys
                .map(key => this.blocks.find(b => b._key === key))
                .filter(Boolean)
        },

        serializeBlocks() {
            const form = document.getElementById('page-form')
            form.querySelectorAll('[data-block-field]').forEach(el => el.remove())

            this.blocks.forEach((block, index) => {
                const add = (name, value) => {
                    const input = document.createElement('input')
                    input.type = 'hidden'
                    input.name = name
                    input.value = value ?? ''
                    input.dataset.blockField = '1'
                    form.appendChild(input)
                }

                add(`blocks[${index}][id]`, block.id ?? '')
                add(`blocks[${index}][component]`, block.component)
                add(`blocks[${index}][position]`, index)
                this.flattenContent(block.content, `blocks[${index}][content]`, add)
            })
        },

        flattenContent(obj, prefix, add) {
            if (obj === null || obj === undefined) {
                add(prefix, '')
                return
            }

            if (Array.isArray(obj)) {
                if (obj.length === 0) {
                    add(`${prefix}[]`, '')
                } else {
                    obj.forEach((item, i) => {
                        if (typeof item === 'object' && item !== null) {
                            this.flattenContent(item, `${prefix}[${i}]`, add)
                        } else {
                            add(`${prefix}[${i}]`, item ?? '')
                        }
                    })
                }
                return
            }

            if (typeof obj === 'object') {
                Object.entries(obj).forEach(([key, value]) => {
                    this.flattenContent(value, `${prefix}[${key}]`, add)
                })
                return
            }

            add(prefix, obj)
        },

        buildEmptyContent,

        async openMediaPicker(content, field) {
            const picker = Alpine.store('mediaPicker')

            if (!picker.items.length) {
                await picker.loadItems()
            }

            const filter = field.type === 'image' ? 'image'
                : field.type === 'video' ? 'video'
                    : 'all'

            const multi = field.type === 'gallery'
            const result = await picker.open(filter, multi)

            if (field.type === 'gallery') {
                content[field.name] = [...(content[field.name] || []), ...result]
            } else {
                content[field.name] = result[0] ?? null
            }
        }
    }
}