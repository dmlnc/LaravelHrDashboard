<template>
    <div>
        <div>
            <a-upload-dragger :class="{'uploader-disabled': maxCount <= allImages.length}" @change="handleFileStatus" :disabled="maxCount <= allImages.length" :headers="getHeaders" :show-upload-list="false" name="file" :maxCount="maxCount - allImages.length" :multiple="false" :action="`/api/v1/${action}`">
                <p class="ant-upload-drag-icon" v-if="maxCount > allImages.length">
                    <inbox-outlined></inbox-outlined>
                </p>
                <p class="">Загрузить изображение({{allImages.length}}/{{maxCount}})</p>
            </a-upload-dragger>
        </div>
        <a-list size="small" v-if="allImages.length" item-layout="horizontal" :data-source="allImages">
            <template #renderItem="{ item }">
                <a-list-item class="p-5">
                    <template #actions v-if="!item.loading">
                        <a-popconfirm @click.stop :title="'Уверены, что хотите удалить изображение?'" ok-text="Да" cancel-text="Нет" @confirm="deleteImage(item.id)">
                            <a-button size="small" type="link" danger key="list-delete">
                            <delete-outlined />
                        </a-button>
                        </a-popconfirm>
                         <!-- <a-button @click.prevent="deleteImage(item.id)" type="link" danger key="list-delete">
                            <delete-outlined />
                        </a-button> -->
                    </template>
                    <a-list-item-meta description="">
                        <template #title>
                            {{ item.name }}
                        </template>
                        <template #avatar>
                            <!-- <a-image  :src="item.url" alt=""/> -->
                            <a-avatar v-if="!item.loading" shape="square" :src="item.url" />
                            <div v-else>
                                <loading-outlined :spin="true" />
                            </div>
                        </template>
                    </a-list-item-meta>
                </a-list-item>
            </template>
        </a-list>
    </div>
</template>
<script>
import { InboxOutlined, DeleteOutlined, LoadingOutlined } from "@ant-design/icons-vue";
import { notification } from 'ant-design-vue';

import AuthUtil from '@/libs/auth/auth';

export default ({
    props: {
        action: {
            type: String,
            required: true
        },
        // id: {
        //     type: [Number, null],
        //     default: null
        // },
        images: {
            type: Array,
            default: () => []
        },
        maxCount: {
            type: Number,
            default: 1
        },
        collection: {
            type: [String, null],
            default: null
        }
    },
    components: {
        InboxOutlined,
        DeleteOutlined,
        LoadingOutlined
    },

    watch: {
        async images(newVal, oldVal) {
            if (newVal == oldVal) {
                return
            }

            if (Array.isArray(this.images)) {
                this.allImages = JSON.parse(JSON.stringify(this.images));
            } else {
                this.allImages = [];
            }
            this.deletes = [];

            await this.getImages();

            this.emitSelectedIds();
        }
    },

    async mounted() {
        this.allImages = JSON.parse(JSON.stringify(this.images));
        this.deletes = [];
        await this.getImages();
        this.emitSelectedIds();
    },

    data() {
        return {
            allImages: [],
            deletes: [],
        }
    },

    computed: {
        getHeaders() {
            let headers = {};
            if (this.collection !== null) {
                headers['collection_name'] = this.collection;
            }
            // if (this.id !== null) {
            //     headers['model_id'] = this.id;
            // }
            headers['Authorization'] = `Bearer ${AuthUtil.getAuthToken()}`;
            return headers;
        }

    },

    methods: {
        deleteImage(id) {
            this.loading = true;


            // TODO: Delete from db if model_id 0?

            this.$axios.delete('media/' + id)
                .then(response => {
                    notification.success({
                        message: 'Успешно',
                    });

                    this.allImages = this.allImages.filter(item => item.id != id);
                    this.deletes = [...this.deletes, id];

                    this.emitSelectedIds();
                })
                .catch(error => {
                    notification.error({
                        message: 'Ошибка',
                        // description: error,
                    });
                })
                .then(() => {});
        },

        getImages() {
            this.allImages.forEach(obj => {
                obj.loading = false;
            });
        },

        emitSelectedIds() {
            const selectedIds = this.allImages
                .filter(obj => !obj.loading) // filter objects where loading is false
                .map(obj => obj.id); // extract the IDs of the remaining objects
            this.$emit('update:modelValue', selectedIds); // emit the selected IDs to parent component's v-model
        },

        handleFileStatus(info) {

            let file = info.file;
            let status = file.status;
            console.log(file)
            if (status === 'uploading') {
                // Check if file with the same UID already exists in allImages array
                const existingFile = this.allImages.find(obj => obj.id === file.uid);
                if (!existingFile) {
                    // Add new object to allImages array with loading = true and name = file.name, id = file.uid
                    this.allImages.push({ loading: true, name: file.name, id: file.uid });
                }
            } else if (status === 'error') {
                notification.error({
                    message: 'Ошибка',
                });
                // Remove object from allImages array with id = file.uid
                this.allImages = this.allImages.filter(obj => obj.id !== file.uid);
            } else if (status === 'done') {
                notification.success({
                    message: 'Успешно',
                });
                // Find object in allImages array with id = file.uid
                const imageIndex = this.allImages.findIndex(obj => obj.id === file.uid);
                if (imageIndex >= 0) {
                    // Update object with id = file.uid to use response ID, name, and URL and set loading to false
                    let response = JSON.parse(file.xhr.response);
                    response = response.data;
                    const updatedImage = {
                        loading: false,
                        name: response.name,
                        id: response.id,
                        url: response.url,
                    };
                    this.allImages.splice(imageIndex, 1, updatedImage);
                    // Call emitSelectedIds method to update parent component's v-model
                    this.emitSelectedIds();
                }
            }

            // console.log(this.allImages)

        }


    }
})

</script>
<style>
.uploader-disabled {
    opacity: 0.5;
}

.ant-list-item-meta-title {
    margin-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
