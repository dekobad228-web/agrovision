import { showModal } from './modal.js'
import MicroModal from 'micromodal'

export default function mediaPickerModal() {
    return {
        items: [],
        filter: 'all',
        multi: false,
        selected: [],
        _resolve: null,

        async loadItems() {
            try {
                const res = await fetch('/admin/media?json=1')
                if (!res.ok) throw new Error(`HTTP ${res.status}`)
                this.items = await res.json()
            } catch (e) {
                console.error('MediaPicker: ошибка загрузки', e)
            }
        },

        open(filter = 'all', multi = false) {
            this.filter = filter
            this.multi = multi
            this.selected = []

            showModal('modal-media-picker')

            return new Promise(resolve => {
                this._resolve = resolve
            })
        },

        get filtered() {
            if (this.filter === 'all') return this.items
            return this.items.filter(i => i.type === this.filter)
        },

        toggle(item) {
            if (!this.multi) {
                this._resolve([item])
                MicroModal.close('modal-media-picker')
                return
            }
            const idx = this.selected.findIndex(s => s.id === item.id)
            idx === -1 ? this.selected.push(item) : this.selected.splice(idx, 1)
        },

        isSelected(item) {
            return this.selected.some(s => s.id === item.id)
        },

        confirm() {
            this._resolve([...this.selected])
            MicroModal.close('modal-media-picker')
        }
    }
}