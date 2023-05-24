<template>
  <a-drawer
      :title="'Вакансия ' + name"
      :width="400"
      :visible="visible"
      :body-style="{ paddingBottom: '80px' }"
      :footer-style="{ textAlign: 'right' }"
      @close="onClose"
  >
    <a-skeleton active :loading="loading" >
      <a-form
          layout="vertical"
          ref="formRef"
          :model="form"
          :rules="rules"
          @submit="handleSubmit"
          :hideRequiredMark="true"
      >
        <a-form-item class="mb-10" label="Изображение (600 x 400)" name="image" :colon="false">
          <ImageUpload v-model="form.images" action='vacancy/media' :images="form.media" :maxCount="1"></ImageUpload>
        </a-form-item>
        <a-form-item class="mb-10" label="Название" name="name" :colon="false">
          <a-input
              v-model:value="form.name"
          />
        </a-form-item>

        <a-form-item class="mb-20" label="Описание" name="description" :colon="false">

          <QuillEditor v-if="visible" theme="snow"
                     v-model:content="form.description"
                     @ready="onEditorReady($event)"
                     :options="editorOption"
                     contentType="html"
          />
        </a-form-item>

        
        <a-form-item>
          <a-button type="primary" block html-type="submit" >
            Сохранить
          </a-button>
        </a-form-item>
      </a-form>
    </a-skeleton>




  </a-drawer>
</template>

<script>


import ImageUpload from '@/components/Images/ImageUpload.vue'

import { notification } from 'ant-design-vue';
import AuthUtil from '@/libs/auth/auth';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor, Quill } from '@vueup/vue-quill'


export default ({


  data() {
    return {
      data: {},
      initialForm: {
        name: '',
        thumbnail:'',
        description:'',
        media:[],
        images:[],
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
      initialId: null,
      loading: false,
      form: {},
      rules: {
        name: [
          { required: true, message: 'Введите название', trigger: 'blur' },
        ],
        description: [
          { required: true, message: 'Введите описание', trigger: 'blur' },
        ],

      }
    }
  },

  props: [
    'id',
    'visible'
  ],
  components:{
    QuillEditor,
    ImageUpload,
  },
  computed:{
    name(){
      if(this.initialId != null){
        return this.form.name
      }

      return '';
    }
  },

  beforeCreate() {
    // Creates the form and adds to it component's "form" property.
    // this.form = this.$form.createForm(this, { name: 'normal_login' });
  },

  watch:{
    visible(){
      this.visibleForm = this.visible;
      this.resetForm()

    },
    id(){
      this.initialId = this.id;
      if(this.id!=null){
        this.loadData(this.id)
      }
      else{
        this.loading = false;
      }
    },
  },

  mounted(){
    this.resetForm();
  },

  methods: {
    onEditorReady (e) {
      console.log(e);
      console.log(this.form.long_text);
      // e.container.querySelector('.ql-blank').innerHTML = this.form.long_text
    },
    resetForm(){
      this.form = {...this.initialForm};
    },
    loadData(id){
      this.loading = true;
      this.$axios.get(`/vacancy/${id}`)
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

    onClose(){
      this.resetForm();
      // this.visibleForm = false;
      this.$emit('close');
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
      let url = `/vacancy`;
      if(this.initialId!=null){
        data._method = "put";
        url = url + '/' + this.initialId;
      }

      let formData = data

      this.$axios.post(url, formData)
          .then(response => {
            // console.log(response)
            this.initialId = response.data.data.id;
            this.loadData(this.initialId);
            this.$emit('save');
            this.$emit('close');
            notification.success({
              message: 'Успешно',
            });

            // const token = response.data.token;
            // setAuthToken(token);
            // router.push({ name: 'Home' })
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
