
<template>
    <div class="rii-wrapper is-vue">
        <input @change="fileUploaded" type="file" class="v-rii-content-input d-none" accept="image/*">
        <div class="row">
            <div class="col-4">
                <div class="v-rii-box" @click="imageBoxClick">
                    <img v-if="file.url" :src="file.url">
                    <span v-if="!file.url">
                        <br>Drag files here,<br>or click to upload
                    </span>
                </div>
            </div>
            <div class="col-8">
                <table class="rii-inputs">
                    <tr>
                        <td>
                            <label for="">Name:</label>
                        </td>
                        <td>
                            <input type="text" class="rii-input form-control rii-filename" :value="file.original_name" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Alt:</label>
                        </td>
                        <td>
                            <input type="text" class="rii-input form-control rii-filealt" v-model="file.alt">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Title:</label>
                        </td>
                        <td>
                            <input type="text" class="rii-input form-control rii-filetitle" v-model="file.title">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value'],
    inject: [
        'helpers'
    ],
    data() {
        return {
            file: {...this.value}
        };
    },
    watch: {
        file: {
            handler: function(val) {
                // console.log(`value changed`, this.file); //! LOG
                this.$emit('fileChanged', {...this.file});
            },
            deep: true
        }
    },
    methods: {
        imageBoxClick(event) {
            let wraper = this.helpers.findParent(event.target, '.rii-wrapper');
            wraper.querySelector('.v-rii-content-input').click();
        },
        fileUploaded(event) {
            this.setFile(event.target.files[0]);
        },
        dropped(e) {
            e.preventDefault();
            this.setFile(e.dataTransfer.items[0].getAsFile());
        },
        setFile(file) {
            let alt = file.name.split('.');
            alt = alt.length==1 ? alt[0] : alt.slice(0, -1).join('.');
            console.log(`before`, alt); //! LOG
            alt = alt.replace(/-/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            console.log(`agter`, alt); //! LOG

            this.file.alt = alt;
            this.file.title = alt;
            this.file.file = file;
            this.file.original_name = file.name;
            this.file.url = URL.createObjectURL(file);
        }
    },
    mounted() {
        // console.log('mounted'); 
        this.$el.querySelector('.v-rii-box').addEventListener('dragover', (e) => e.preventDefault());
        this.$el.querySelector('.v-rii-box').addEventListener('drop', this.dropped);
    }
};
</script>
