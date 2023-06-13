<template>
  <a-drawer
    :title="'Ресторан ' + name"
    :width="320"
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
          <a-form-item class="mb-10" label="Название" name="name" :colon="false">
            <a-input 
              v-model:value="form.name"
            />
          </a-form-item>

          <a-form-item class="mb-10" label="Привязанные вакансии" name="vacancies" :colon="false">
            <a-select v-model:value="form.vacancies" mode="multiple" :options="vacancies"></a-select>
          </a-form-item>
         
          <!-- {{ this.form.vacancies_data }}<br><br>
          {{ this.form.vacancies }}<br><br>
          {{ vacancies_data }} -->

          <div class="" v-for="(vacancy, index) in form.vacancies">
            <p><b>Вакансия: {{ this.vacancies_data[vacancy].name }}</b></p>
            <a-form-item class="mb-10" label="Цена за час" name="price_per_hour" :colon="false">
              <a-input-number  style="width: 100%" 
                v-model:value="this.form.vacancies_data[vacancy].price_per_hour"
              />
            </a-form-item>

          </div>

          
          
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



import { notification } from 'ant-design-vue';


  export default ({


    data() {
      return {
        text: null,
        initialForm: {
          name: '',
          vacancies: [],
          vacancies_data: [],
        },
        vacancies: [],
        vacancies_data: [],
        initialId: null,
        loading: false,
        form: {},
        rules: {
              name: [
                  { required: true, message: 'Введите название', trigger: 'blur' },
              ],
            }
      }
    },

    props: [
      'id',
      'visible'
    ],

    computed:{
      name(){
        if(this.initialId != null){
          return this.form.name
        }

        return '';
      }
    },

    watch:{
      visible(){
        this.visibleForm = this.visible;
        this.initialId = this.id;
        if(this.id!=null){
          this.loadData(this.id)
        }
        else{
          this.updateVacancies();

          this.loading = false;
        }
      },
      id(){
        

      },
    },

    mounted(){
      this.resetForm();
      this.fetchVacancies();
    },

    methods: {

      resetForm(){
        this.form = {...this.initialForm};
        this.updateVacancies();
      },

      updateVacancies(){
        let formVacanciesData = JSON.parse(JSON.stringify(this.vacancies_data));
        this.form.vacancies_data = formVacanciesData;
      },

      fetchVacancies(){
        this.loading = true;
        this.$axios.get('/vacancy')
            .then(response => {
                this.vacancies =  response.data.data.map(vacancy => ({
                        label: vacancy.name,
                        value: vacancy.id,
                }));

                let vacanciesData = {};
                
                this.vacancies = response.data.data.map(vacancy => {
                  vacanciesData[vacancy.id] = {
                    id: vacancy.id,
                    name: vacancy.name,
                    price_per_hour: 0,
                  };

                  return {
                    label: vacancy.name,
                    value: vacancy.id,
                  };
                });

                this.vacancies_data = vacanciesData;
                this.updateVacancies();
                


                // router.push({ name: 'Academy', params: {academy_id: } })
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


      loadData(id){
        

        this.loading = true;
        this.$axios.get('/restaurant/'+id)
            .then(response => {
                this.form = response.data.data;
                // this.form.vacancies_data =  response.data.data.vacancies.map(vacancy => vacancy);
                let formVacanciesData = JSON.parse(JSON.stringify(this.vacancies_data));
                
                this.form.vacancies = response.data.data.vacancies.map(vacancy => {
                  formVacanciesData[vacancy.id].price_per_hour = vacancy.price_per_hour;
                  return vacancy.id;
                });
                this.form.vacancies_data = formVacanciesData;

            })
            .catch(error => {
              console.error(error)
                notification.error({
                    message: 'Ошибка',
                    // description: error,
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
        // console.log(this.$refs.formRef.validate())
        // // this.$refs.formRef.target.validate();
        // console.log(this.form
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
        let url = "restaurant";
        if(this.initialId!=null){
          data._method = "put";
          url = url + '/' + this.initialId;
        }

        let formData = data

        this.$axios.post(url, formData)
          .then(response => {
            // console.log(response)
            // this.initialId = response.data.data.id;
            // this.loadData(this.initialId);
            this.$emit('save');
            notification.success({
              message: 'Успешно',
            });

            this.onClose();

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
