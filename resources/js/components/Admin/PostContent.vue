<template>
    <div>
        <div class="card">
            <div class="card-header row">
                <h5 class="m-0 col">
                    Content
                    <button type="button" class="btn btn-info" @click="check()">check</button>
                </h5>
                <div class="col">
                    <button type="button" class="btn btn-success d-block float-right" @click="addBlock()">Add Block</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div v-for="(block, bi) in blocks.sort((a,b) => a.order - b.order)" :key="bi" class="card card-secondary w-100">
                        <div class="card-header">
                            <div class=" row">
                                <div class="col">
                                    <h5 class="m-0 d-inline">id=</h5>
                                    "<input type="text" class="form-control d-inline w-auto" v-model="block.ident">"
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-warning d-block float-right" @click="removeBlock(bi)">Remove</button>
                                    <button type="button" class="btn btn-success d-block mr-2 float-right" @click="addItem(bi)">Add Item</button>
                                    <button v-if="bi != 0" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(blocks, bi, 'up')">^</button>
                                    <button v-if="blocks.length != 1 && blocks.length-1 != bi" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(blocks, bi, 'down')">v</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row block-item-wrapper">
                                <div v-for="(item, ii) in block.items.sort((a,b) => a.order - b.order)" :key="ii" class="col-md-12">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <select v-model="item.type" class="form-control w-auto d-inline item-type-select">
                                                <option v-for="(iType, iti) in dataprops.itemTypes" :key="iti" :value="iType">{{iType}}</option>
                                            </select>
                                            <button type="button" class="btn btn-warning remove-item float-right" @click="removeItem(bi, ii)">Remove</button>
                                            <button v-if="ii != 0" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(block.items, ii, 'up')">^</button>
                                            <button v-if="block.items.length != 1 && block.items.length-1 != ii" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(block.items, ii, 'down')">v</button>
                                        </div>
                                        <template v-if="['title', 'text'].includes(item.type)">
                                            <ul class="nav nav-tabs" style="display: flex;">
                                                <li v-for="(localeParams, locale) in dataprops.locales" :key="locale" class="nav-item">
                                                    <a
                                                        :href="`#test${locale}`"
                                                        class="nav-link"
                                                        :class="{ active: (item.langTab??'en')==locale }"
                                                        @click="item.langTab = locale"
                                                    >
                                                        {{locale}}
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div v-for="(localeParams, locale) in dataprops.locales" :key="locale" class="tab-pane" :class="{ active: (item.langTab??'en')==locale }">
                                                    <input v-if="item.type == 'title'" v-model="item.value[locale]" class="form-control" type="text">
                                                    <textarea v-if="item.type == 'text'" v-model="item.value[locale]" class="form-control summernote"></textarea>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else-if="item.type == 'image'">
                                            <div class="custom-file">
                                                <input @change="fileUploaded(item, $event)" type="file" class="custom-file-input">
                                                <label class="custom-file-label">{{item.value.original_name ?? item.previewName ?? 'Choose file'}}</label>
                                            </div>
                                            <img :src="item.value.url ?? item.previewImage ?? ''" alt="" class="custom-file-preview">
                                        </template>
                                        <template v-else-if="item.type == 'slider'">
                                            TODO
                                        </template>
                                        <template v-else-if="item.type == 'video'">
                                            <div class="show-uploaded-file-name">
                                                <div class="custom-file">
                                                    <input @change="fileUploaded(item, $event)" type="file" class="custom-file-input">
                                                    <label class="custom-file-label">{{item.value.original_name ?? 'Choose file'}}</label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100 mr-2" @click="save()">Save</button>
        <a href="/admin/posts" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </div>
</template>

<script>
export default {
    props: [
        'dataprops'
    ],
    inject: [
        'helpers'
    ],
    components: {

    },
    data: () => ({
        blocks: [],
    }),
    computed: {

    },
    methods: {
        check() {
            console.log('blocks:', [...this.blocks]);
        },
        fileUploaded(obj, event) {
            let file = event.target.files[0];

            obj.value = file;
            obj.previewImage = URL.createObjectURL(file);
            obj.previewName = file.name;
        },
        move(elems, i, direction) {
            let next = direction == 'up' ? elems[i-1] : elems[i+1];
            let curr = elems[i];
            if (!next) {
                return;
            }
            let trgOrder = next.order;
            next.order = curr.order;
            curr.order = trgOrder;
        },
        addBlock() {
            let maxOrder = this.blocks.length
                ? Math.max(...this.blocks.map(o => o.order))
                : 0;
            this.blocks.push({
                ident: '',
                items: [],
                order: maxOrder+1
            });
        },
        removeBlock(i) {
            this.blocks.splice(i, 1);
        },
        addItem(bi) {
            let maxOrder = this.blocks[bi].items.length
                ? Math.max(...this.blocks[bi].items.map(o => o.order))
                : 0;
            this.blocks[bi].items.push({
                type: 'title',
                order: maxOrder+1,
                langTab: 'en',
                value: {}
            });
        },
        removeItem(bi, ii) {
            this.blocks[bi].items.splice(ii, 1);
        },
        save() {
            let app = this;
            this.helpers.showLoading();

            let formData = new FormData();
            this.helpers.objToFormData(formData, {blocks: this.blocks});

            axios.post(`/admin/posts/${this.dataprops.post.id}/update-content`,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then(response => {
                console.log('response', response);

                app.helpers.showNotif(response.data.message, '', response.data.success).then(res => {
                    window.location.reload();
                });
            })
            .catch(error => {
                if (error.response.status == 422) {
                    app.helpers.showError('Validation error', error.response.data.message)
                } else {
                    app.helpers.showError()
                }
            });
        }
    },
    created() {
        console.log('DATAPROPS:', this.dataprops); //!LOG
        this.blocks = this.dataprops.post.blocks;

        for(let dataKey in this.blocks) {
            console.log('dataKey', dataKey); //! LOG
        }
    }
}
</script>
