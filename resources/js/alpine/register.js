import Alpine from './core.js'
import pageEditor from '../admin/pageEditor.js'
import openModal from '../admin/openModal.js'
import tinymceEditor from '../admin/tinymceEditor.js'
import mediaPickerModal from '../admin/mediaPickerModal.js'

export function registerAdmin() {
    Alpine.store('mediaPicker', mediaPickerModal())
    Alpine.data('pageEditor', pageEditor)
    Alpine.data('tinymceEditor', tinymceEditor)
    Alpine.data('openModal', openModal)
}