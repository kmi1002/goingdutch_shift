<template>
    <div class="tmp">
        <froala :tag="'textarea'" :config="config" v-model="model"></froala>
    </div>
</template>

<script>

    export default {
        props: {
            froalaKey: {
                type: String,
                default: ''
            },
            froalaHash: {
                type: String,
                default: ''
            },
            text: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                editor: null,
                config: {
                    key: this.froalaKey,
                    toolbarInline: true,
                    toolbarButtons: ['insertImage', 'insertVideo', 'insertLink'],
                    quickInsertTags: [],
                    fontFamilySelection: true,
                    fontSizeSelection: true,
                    paragraphFormatSelection: true,
                    charCounterCount: false,
                    heightMin: 300,
                    imageUploadToS3: JSON.parse(this.froalaHash),
                    fileUploadToS3: JSON.parse(this.froalaHash),
                    pastePlain: true,
                    imageDefaultWidth: 500,
                    imageMaxSize: 10 * 1024 * 1024,
                    events: {
                        'froalaEditor.initialized': function (e, editor) {
                            this.editor = editor
                        },
                        'froalaEditor.focus': function (e, editor) {
                            // this.$emit('handleInputFocus', editor.selection.get());
                        },
                        'froalaEditor.blur': function (e, editor) {
                            // this.$emit('handleInputBlur', editor.selection.get());
                        },
                        'froalaEditor.contentChanged': function (e, editor) {
                            this.$emit('on-chnage', editor.html.get(true));
                        }

                    }
                },
                placeholder: "Edit Me",
                model: this.text
            }
        },
        methods: {
            setHtml: function (html) {
                this.editor.html.set(html);
            },
        }
    }
</script>

<style scoped>
    .tmp {
        padding: 5px;
        border: 1px solid #ededed;
    }
</style>