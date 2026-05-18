export default function pageEditor(initialBlocks = [], registry = {}) {
    return {
        registry,
        blocks: initialBlocks ?? [],
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
                id: crypto.randomUUID(),
                component: componentName,
                content: this.buildEmptyContent(component)
            })
        },

        removeBlock(index) {
            this.blocks.splice(index, 1)
        },

        buildEmptyContent(component) {
            const content = {}
            component.fields.forEach(field => {
                content[field.name] = field.type === 'gallery' ? [] : null
            })
            return content
        },

        async openMediaPicker(block, field) {
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
                block.content[field.name] = [
                    ...(block.content[field.name] || []),
                    ...result
                ]
            } else {
                block.content[field.name] = result[0] ?? null
            }
        }
    }
}