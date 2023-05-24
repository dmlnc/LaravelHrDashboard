<template>
    <div>
    	
        <a-typography-title :level="5" class="mb-40">Landing</a-typography-title>

        <a-skeleton active :loading="loading" >
        <a-form
            layout="vertical"
            ref="formRef"
            :model="form"
            :rules="rules"
            @submit="handleSubmit"
            :hideRequiredMark="true"
        >
            <h4 class="mb-20">Слайдер</h4>
            <div class="p-20 mb-20" style="border: 1px solid #ccc;">
                <a-form-item class="mb-10" label="Изображение для слайдера (1200x600)" name="image_slider" :colon="false">
                    <ImageUpload v-model="form.images_slider" action='page/media/slider' :images="form.media_slider" :maxCount="10"></ImageUpload>
                </a-form-item>
            </div>
            <h4 class="mb-20">Преимущества</h4>
            <div class="p-20 mb-20" style="border: 1px solid #ccc;">
                <a-form-item class="mb-20" label="Описание" name="about" :colon="false">
                    <QuillEditor v-if="!loading" theme="snow"
                            v-model:content="form.about"
                            :options="editorOption"
                            contentType="html"
                    />
                </a-form-item>
                <a-form-item class="mb-10" label="Изображение для преимуществ (600x400)" name="image_benefits" :colon="false">
                    <ImageUpload v-model="form.images_benefits" action='page/media/benefits' :images="form.media_benefits" :maxCount="10"></ImageUpload>
                </a-form-item>
            </div>
            <h4 class="mb-20">Контакты</h4>
            <div class="p-20 mb-20" style="border: 1px solid #ccc;">
                <a-form-item class="mb-10" label="Номер телефона" name="phone" :colon="false">
                    <a-input v-model:value="form.phone" />
                </a-form-item>
                
                <a-form-item class="mb-10" label="Email" name="email" :colon="false">
                    <a-input v-model:value="form.email" />
                </a-form-item>
            </div>
            <h4 class="mb-20">Частые вопросы:</h4>
            <div class="p-20 mb-20" style="border: 1px solid #ccc;">
                <div style="margin-bottom: 10px" v-for="(question, index) in form.questions">
                    
                    <a-form-item class="mb-10" label="Название вопроса" name="name" :colon="false">
                        <a-input v-model:value="form.questions[index].name" />
                    </a-form-item>
                    <QuillEditor v-if="!loading" theme="snow"
                            v-model:content="form.questions[index].answer"
                            :options="editorOption"
                            contentType="html"
                    />
                </div>
                <a-button type="primary" block ghost class="mt-20 mb-10" @click="addQuestion">
                    Добавить вопрос
                </a-button>
            </div>
                        

            <a-form-item>
                <a-button type="primary" block html-type="submit" >
                    Сохранить
                </a-button>
            </a-form-item>
        </a-form>
    </a-skeleton>

    </div>
</template>
<script>



import ImageUpload from '@/components/Images/ImageUpload.vue'

import { notification } from 'ant-design-vue';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor, Quill } from '@vueup/vue-quill'

export default ({
    data() {
        return {
            initialForm: {
                about: '',
                questions: [],
                media_slider:[],
                images_slider:[],
                media_benefits:[],
                images_benefits:[],
            },
            editorOption: {
                modules: {
                toolbar: {
                    container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    // ['blockquote'],

                    // [{'header': 1}, {'header': 2}],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    // [{'color': []}, {'background': []}],
                    // [{'align': []}],
                    // ['image', 'video'],
                    ['clean'],
                    ],
                },
                history: {
                    delay: 1000,
                    maxStack: 50,
                    userOnly: false
                },
                }
            },
            loading: false,
            form: {},
            rules: {
                about: [
                    { required: true, message: 'Введите описание', trigger: 'blur' },
                ],
            }
        }
    },
    components:{
        QuillEditor,
        ImageUpload,
    },

    mounted() {
        this.loadData(1)
        this.resetForm();
    },

    methods: {
        addQuestion(){
            let question = {
                name: '',
                answer: '',
            };
            this.form.questions.push(question);
        },
        resetForm(){
            this.form = {...this.initialForm};
        },
        loadData(id){
            this.loading = true;
            this.$axios.get(`/page/${id}`)
                .then(response => {
                    this.form = response.data.data;
                })
                .catch(error => {
                    notification.error({
                    message: 'Ошибка',
                    //description: error,
                    });
                })
                .then(()=>{
                    this.loading = false;
                });
        },
        handleSubmit(e) {
            e.preventDefault();
            this.$refs.formRef
                .validate()
                .then((e) => {})
                .catch((e) => {
                    if(e.errorFields.length == 0){
                    this.submitForm();
                    }
                })
        },

        submitForm(){
            let data = {...this.form};
            let url = `/page`;

            data._method = "put";
            url = url + '/1';

            let formData = data

            this.$axios.post(url, formData)
                .then(response => {
                    // console.log(response)
                    // this.initialId = response.data.data.id;
                    this.loadData(1);
                    // this.$emit('save');
                    // this.$emit('close');
                    notification.success({
                    message: 'Успешно',
                    });
                })
                .catch(error => {
                    notification.error({
                    message: 'Ошибка',
                    //description: error,
                    });
                });
        },

    	
    }
})

</script>
<style lang="scss">
</style>
