<!-- 
	This is the sign in page, it uses the dashboard layout in: 
	"./layouts/Default.vue" .
 -->

<template>
	<div class="sign-in" style="width: 100%;">
		
		<a-row type="flex" :gutter="[24,24]" justify="space-around" align="middle">

			<!-- Sign In Form Column -->
			<a-col :span="24" :md="12" :lg="{span: 12, offset: 0}" :xl="{span: 6, offset: 2}" class="col-form">
				<h1 class="mb-15">Войти</h1>
				<h5 class="font-regular text-muted">Укажите ваш email и пароль</h5>

				<a-form
					id="components-form-demo-normal-login"
					layout="vertical"
					ref="formRef"
					:model="form"
					:rules="rules"
					class="login-form"
					@submit="handleSubmit"
					:hideRequiredMark="true"
				>
					<a-form-item class="mb-10" label="Email" name="email" :colon="false">
						<a-input 
							v-model:value="form.email"
						/>
					</a-form-item>
					<a-form-item class="mb-5" label="Пароль" name="password" :colon="false">
						<a-input
							v-model:value="form.password"
						type="password"/>
					</a-form-item>
					
					<a-form-item>
						<a-button type="primary" block html-type="submit" class="login-form-button">
							Войти
						</a-button>
					</a-form-item>
				</a-form>
				<!-- / Sign In Form -->

			</a-col>
			<!-- / Sign In Form Column -->

			<!-- Sign In Image Column -->
			<a-col :span="24" :md="12" :lg="12" :xl="12" class="col-img">
				<img src="https://doodleipsum.com/700/flat?i=042c8576c15db0c6506f27e0736510a5" alt="">
			</a-col>
			<!-- Sign In Image Column -->

		</a-row>
		
	</div>
</template>


<script>
	import AuthUtil from '@/libs/auth/auth';
	import router from '@/router'


	export default ({
		data() {
			return {
				// Binded model property for "Sign In Form" switch button for "Remember Me" .
				rememberMe: true,
				text: null,
				form: {
					email: '',
					password: '',
				},
				rules: {
      				email: [
      				  	{ required: true, message: 'Пожалуйста, введите email', trigger: 'blur' },
      				],
      				password:[
      					{ required: true, message: 'Пожалуйста, введите пароль', trigger: 'blur' },
      				]
      			}

			}
		},
		beforeCreate() {
			// Creates the form and adds to it component's "form" property.
			// this.form = this.$form.createForm(this, { name: 'normal_login' });
		},
		methods: {
			// Handles input validation after submission.
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
				// sendAxios
				this.$axios.post('/login', this.form)
  				.then(response => {
  				  const token = response.data.token;
  				  const user = response.data.user;
  				  AuthUtil.setAuthToken(token);
  				  AuthUtil.setUser(user);
  				  router.push({ name: 'Home' })
  				})
  				.catch(error => {
  				  console.error(error);
  				});
			}
		},
	})

</script>

<style lang="scss">
	body {
		background-color: #ffffff;
	}
</style>