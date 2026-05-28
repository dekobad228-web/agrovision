import tinymce from 'tinymce/tinymce'

export default function tinymceEditor(content, fieldName) {
    return {
        editorId: 'tinymce-' + Math.random().toString(36).slice(2),
        content,
        fieldName,

        init() {
            this.$nextTick(() => {
                tinymce.init({
                    selector: '#' + this.editorId,
                    license_key: 'gpl',       
                    skin: false,            
                    content_css: false, 
                    menubar: false,
                    plugins: 'lists link code',
                    toolbar: 'blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
                    height: 250,
                    setup: (editor) => {
                        editor.on('Change KeyUp', () => {
                            this.content[this.fieldName] = editor.getContent()
                        })
                        editor.on('init', () => {
                            editor.setContent(this.content[this.fieldName] ?? '')
                        })
                    }
                })
            })
        },

        destroy() {
            tinymce.get(this.editorId)?.remove()
        }
    }
}