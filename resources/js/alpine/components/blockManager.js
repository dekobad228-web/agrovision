export default (initialBlocks = [], registry = {}) => ({
    blocks: initialBlocks,
    registry: registry,

    addBlock(componentName) {
        if(!this.registry[componentName]) return

        const newBlock = {
            id: null,
            component: componentName,
            name: this.registry[componentName].name,
            content: this.registry[componentName].fields.reduce((acc, field) => {
                acc[field.name] = '';
                return acc
            }, {})
        }

        this.blocks.push(newBlock)
    },

    removeBlock(index) {
        if(confirm('Удалить этот блок?')) {
            this.blocks.splice(index, 1)
        }
    },

    handleSort(e) {
        const newOrder = e.detail
        const reordered = newOrder.map(index => this.blocks[index])
        this.blocks = reordered
    },

    prepareForSubmit() {
        return true
    }
})