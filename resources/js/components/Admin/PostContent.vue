<template>
    <div>
        <div class="card">
            <div class="card-header row">
                <h5 class="m-0 col">Groups for {{ blocks.length }} blocks</h5>
                <div class="col">
                    <button type="button" class="btn btn-success d-block float-right" @click="addBlockGroup()">+</button>
                    <button type="button" class="btn btn-info d-block float-right mr-2" @click="subBlockGroup()">-</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <input 
                                    v-for="(blocks_in_group, bgi) in group_blocks" 
                                    :key="bgi" 
                                    type="number" 
                                    class="form-control" 
                                    v-model="group_blocks[bgi]" 
                                    style="max-width:55px;display:inline-block;margin-right:5px;"
                                >
                            </div>
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <h5 class="m-0 col">Post Blocks</h5>
                <div class="col">
                    <button type="button" class="btn btn-success d-block float-right" @click="addBlock()">Add Block</button>
                    <button type="button" class="btn btn-info d-block float-right mr-2" @click="addPreset()">Add Preset</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div v-for="(block, bi) in blocks.sort((a,b) => a.order - b.order)" :key="bi" class="card card-secondary w-100">
                        <div class="card-header">
                            <div class=" row">
                                <div class="col">
                                    <span style="font-size:1.5em">{{ bi+1 }}:</span>
                                    <div class="tab-content" style="display:inline-block">
                                        <input v-model="block.name" class="form-control my-block-title" @input="blockNameChanged(block)" type="text" placeholder="Block name">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-success d-block mr-2 float-right" @click="addItem(bi)">Add Item</button>
                                    <button v-if="blocks.length != 1" type="button" class="btn btn-warning mr-2 d-block float-right" @click="removeBlock(bi)">Remove</button>
                                    <button v-if="bi != 0" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(blocks, bi, 'up')">^</button>
                                    <button v-if="blocks.length != 1 && blocks.length-1 != bi" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(blocks, bi, 'down')">v</button>
                                    <input type="text" class="form-control float-right mr-2 my-block-ident" v-model="block.ident" placeholder="Block anchor" @input="blockIdentChanged(block)">
                                </div>
                            </div>
                        </div>
                        <div class="card-body my-post-block">
                            <div class="row block-item-wrapper">
                                <template v-for="(item, ii) in block.items.sort((a,b) => a.order - b.order)" :key="ii">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                {{ ii+1 }}:
                                                <select v-model="item.type" class="form-control w-auto d-inline item-type-select">
                                                    <option v-for="(iType, iTypeKey) in dataprops.itemTypes" :key="iTypeKey" :value="iTypeKey">
                                                        {{iType}}
                                                    </option>
                                                </select>
                                                <button v-if="item.type == 'image-gallery'" @click="addImageToSlider(item)" class="btn btn-default ml-2">
                                                    Add image
                                                </button>
                                                <button v-if="block.items.length != 1" type="button" class="btn btn-warning remove-item float-right" @click="removeItem(bi, ii)">Remove</button>
                                                <button v-if="ii != 0" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(block.items, ii, 'up')">^</button>
                                                <button v-if="block.items.length != 1 && block.items.length-1 != ii" type="button" class="btn btn-info d-block mr-2 float-right" @click="move(block.items, ii, 'down')">v</button>
                                            </div>
                                            <template v-if="['title-h2','title-h3','title-h4','title-h5'].includes(item.type)">
                                                <input v-model="item.value.value" class="form-control" type="text" placeholder="Title">
                                            </template>
                                            <template v-if="item.type == 'text'">
                                                <div>
                                                    <SummernoteEditor v-model="item.value.value"/>
                                                </div>
                                            </template>
                                            <template v-else-if="['image', 'image-small'].includes(item.type)">
                                                <div class="custom-file">
                                                    <input @change="fileUploaded(item, $event)" type="file" class="custom-file-input" accept="image/*">
                                                    <label class="custom-file-label">{{item.value.original_name ?? item.previewName ?? 'Choose file'}}</label>
                                                </div>
                                                <img :src="item.value.url ?? item.previewImage ?? ''" alt="" class="custom-file-preview">
                                            </template>
                                            <template v-else-if="item.type == 'image-title'">
                                                <input v-model="item.value.title" class="form-control" type="text" placeholder="Title">
                                                <div class="custom-file">
                                                    <input @change="fileUploaded(item, $event)" type="file" class="custom-file-input" accept="image/*">
                                                    <label class="custom-file-label">{{item.value.image?.original_name ?? item.previewName ?? 'Choose file'}}</label>
                                                </div>
                                                <img :src="item.value.image?.url ?? item.previewImage ?? ''" alt="" class="custom-file-preview">
                                            </template>
                                            <template v-else-if="item.type == 'image-text'">
                                                <div>
                                                    <SummernoteEditor v-model="item.value.text"/>
                                                    <div class="custom-file">
                                                        <input @change="fileUploaded(item, $event)" type="file" class="custom-file-input" accept="image/*">
                                                        <label class="custom-file-label">{{item.value.image?.original_name ?? item.previewName ?? 'Choose file'}}</label>
                                                    </div>
                                                    <img :src="item.value.image?.url ?? item.previewImage ?? ''" alt="" class="custom-file-preview">
                                                </div>
                                            </template>
                                            <template v-else-if="item.type == 'image-gallery'">
                                                <div class="row">
                                                    <div v-for="(image, iii) in item.value.images || []" :key="iii" class="col-6">
                                                        <div class="custom-file">
                                                            <input @change="fileUploaded(image, $event)" type="file" class="custom-file-input" accept="image/*">
                                                            <label class="custom-file-label">{{image.original_name ?? image.previewName ?? 'Choose file'}}</label>
                                                        </div>
                                                        <img :src="image.url ?? image.previewImage ?? ''" alt="" class="custom-file-preview">
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else-if="item.type == 'youtube'">
                                                <div>
                                                    <input v-model="item.value.value" class="form-control" type="text" placeholder="https://youtu.be/sg20GbUrbCA?si=eeGeJcDSSTVrhPLg">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <hr>
                                </template>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success d-block float-right" @click="addItem(bi)">Add Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success d-block float-right" @click="addBlock()">Add Block</button>
                <button type="button" class="btn btn-info d-block float-right mr-2" @click="addPreset()">Add Preset</button>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100 mr-2" @click="save()">Save</button>
        <a href="/admin/posts" class="btn btn-outline-secondary text-dark min-w-100 mr-2">Cancel</a>
    </div>
</template>

<script>
export default {
    props: [
        'dataprops'
    ],
    inject: [
        'helpers',
        'alert'
    ],
    components: {

    },
    data: () => ({
        blocks: [],
        group_blocks: []
    }),
    computed: {

    },
    methods: {
        check() {
            console.log('blocks:', [...this.blocks]);
        },
        readable(value) {
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
        async addPreset() {
            const { value: preset } = await this.alert.fire({
                title: 'Select preset of blocks',
                input: 'select',
                inputOptions: {
                    'title+image+text': 'Title + Image + Text',
                    'title+text': 'Title + Text'
                },
                inputPlaceholder: 'Select a preset',
                showCancelButton: true,
                confirmButtonText: 'Select'
            });

            if (!preset) {
                return;
            }

            let maxOrder = this.getMaxOrder();
            if (preset == 'title+image+text') {
                this.blocks.push({
                    ident: '',
                    order: maxOrder+1,
                    name: '',
                    items: [
                        {
                            type: 'title-h2',
                            order: 1,
                            value: this.getDefaultValue()
                        },
                        {
                            type: 'image',
                            order: 2,
                            value: this.getDefaultValue()
                        },
                        {
                            type: 'text',
                            order: 3,
                            value: this.getDefaultValue()
                        }
                    ]
                });
            } else if (preset == 'title+text') {
                this.blocks.push({
                    ident: '',
                    order: maxOrder+1,
                    name: '',
                    items: [
                        {
                            type: 'title-h2',
                            order: 1,
                            value: this.getDefaultValue()
                        },
                        {
                            type: 'text',
                            order: 3,
                            value: this.getDefaultValue()
                        }
                    ]
                });
            }
        },
        fileUploaded(obj, event) {
            let file = event.target.files[0];

            let separateImageTypes = ['image-title', 'image-text'];

            if (separateImageTypes.includes(obj.type)) {
                obj.value.image = file;
            } else {
                obj.value = file;
            }

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
            // $('.summernote').summernote();
        },
        addBlock() {
            let maxOrder = this.getMaxOrder();
            this.blocks.push({
                ident: '',
                name: '',
                items: [
                    {
                        type: 'title-h2',
                        order: 1,
                        value: this.getDefaultValue()
                    }
                ],
                order: maxOrder+1
            });
            this.recalculateGroupBlocks();
        },
        removeBlock(i) {
            this.blocks.splice(i, 1);
            this.recalculateGroupBlocks();
        },
        addItem(bi) {
            let maxOrder = this.getMaxOrder(this.blocks[bi].items);
            this.blocks[bi].items.push({
                type: 'title-h2',
                order: maxOrder+1,
                value: this.getDefaultValue()
            });
        },
        removeItem(bi, ii) {
            this.blocks[bi].items.splice(ii, 1);
        },
        save() {
            let app = this;
            this.helpers.showLoading();

            let formData = new FormData();
            this.helpers.objToFormData(formData, {blocks: this.blocks, group_blocks: this.group_blocks});

            axios.post(this.dataprops.submitUrl,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then(response => {
                app.helpers.showToast(response.data.message, response.data.success);
                // app.helpers.showNotif(response.data.message, '', response.data.success).then(res => {
                //     window.location.reload();
                // });
            })
            .catch(error => {
                if (error.response.status == 422) {
                    app.helpers.showError('Validation error', error.response.data.message)
                } else {
                    app.helpers.showError()
                }
            });
        },
        addImageToSlider(item) {
            if (!item.value.images) {
                item.value.images = [{}];
            } else {
                item.value.images.push({});
            }
        },
        blockNameChanged(block) {
            if (block.id || block.doNotAutoSlug) {
                // do not autoslug when it is block editing
                return;
            }
            block.ident = this.helpers.slugify(block.name);
        },
        blockIdentChanged(block) {
            block.doNotAutoSlug = true;
        },
        addBlockGroup() {
            if (this.blocks.length < this.group_blocks.length + 1) {
                return;
            }
            this.group_blocks.push(0);
            this.recalculateGroupBlocks();
        },
        subBlockGroup() {
            if (this.group_blocks.length == 1) {
                return;
            }

            this.group_blocks.pop();
            this.recalculateGroupBlocks();
        },

        // helpers

        getDefaultValue() {
            return {
                
            };
        },
        getMaxOrder(items=null) {
            if (!items) {
                items = this.blocks;
            }

            return items.length
                ? Math.max(...items.map(o => o.order))
                : 0;
        },
        recalculateGroupBlocks() {
            let res = [];
            let i = 1;
            let newValOg = this.blocks.length / this.group_blocks.length;
            this.group_blocks.forEach(val => {
                let newVal = i == this.group_blocks.length 
                    ? Math.ceil(newValOg) 
                    : Math.floor(newValOg);
                res.push(newVal);
                i++;
            });

            res = res.filter(num => num !== 0);

            this.group_blocks = res;
        }
    },
    created() {
        this.blocks = this.dataprops.post.blocks;
        if (!this.blocks.length) {
            this.addBlock();
            this.group_blocks = [1];
        } else {
            this.group_blocks = this.dataprops.post.block_groups;
        }


        console.log('dataprops: ', this.dataprops);
    }
}
</script>
