<script>
import {mapState} from "vuex";
import router from "@/router";

export default {
  name: "AdminRegister",

  data(){
    return{
      name: '',
      email: '',
      phone: '',
      password: '',
      password_confirmation: '',
      role: 'employee'
    }
  },

  computed: {
    ...mapState({
      message: state => state.success_message,
      errors: state => state.errors,
      success_status: state => state.success_status,
      error_status: state => state.error_status
    })
  },

  mounted() {
  },

  methods: {
    register: async function(){
      try {
        let formData = new FormData();

        formData.append("name", this.name);
        formData.append("email", this.email);
        formData.append("phone", this.phone);
        formData.append("password", this.password);
        formData.append("password_confirmation", this.password_confirmation);

        await this.$store.dispatch("register", formData).then(() => {
          if(this.success_status === 201)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.message,
              showConfirmButton: false,
              timer: 1500
            });

            this.name = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';

            setTimeout(function () {
              router.push({path: '/login'});
            },2000)
          }
        })
      }catch (e) {
        this.$swal.fire({
          icon: 'error',
          text: 'Oops',
          title: 'Something wen wrong!!!',
        });
      }
    }
  }
}
</script>

<template>
  <div class="register">
    <div class="wrapper">
      <form v-on:submit.prevent="register">
        <h2>Register</h2>

        <div class="input-box">
          <input type="text" name="name" v-model="name" placeholder="Name">
          <i class='bx bxs-user'></i>
        </div>
        <p v-if="errors.name" class="error custom_error">{{errors.name[0]}}</p>


        <div class="input-box">
          <input type="text" name="email" v-model="email" placeholder="Email">
          <i class='bx bxs-envelope'></i>
        </div>
        <p v-if="errors.email" class="error custom_error">{{errors.email[0]}}</p>

        <div class="input-box">
          <input type="text" name="phone" v-model="phone" placeholder="Phone">
          <i class='bx bxs-envelope'></i>
        </div>
        <p v-if="errors.phone" class="error custom_error">{{errors.phone[0]}}</p>


        <div class="input-box">
          <input type="password" name="password" v-model="password" placeholder="Password">
          <i class='bx bxs-lock-alt'></i>
        </div>
        <p v-if="errors.password" class="error custom_error">{{errors.password[0]}}</p>


        <div class="input-box">
          <input type="password" name="password_confirmation" v-model="password_confirmation" placeholder="Password Confirmation">
          <i class='bx bxs-lock-alt'></i>
        </div>
        <p v-if="errors.password_confirmation" class="error custom_error">{{errors.password_confirmation[0]}}</p>


        <button type="submit" class="btn">Submit</button>

        <div class="register-link">
          <p>
            Already have an account?
            <router-link :to="{ name: 'AdminLogin' }">Login</router-link>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

.register{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  display: flex;
  justify-content: center !important;
  align-items: center !important;
  min-height: 100vh;
  background: url(../../../assets/img.jpg) no-repeat;
  background-size: cover;
  background-position: center;
}

.wrapper{
  width: 420px;
  background: transparent;
  border: 2px solid rgba(255, 255, 255, .2);
  backdrop-filter: blur(20px);
  color: #fff;
  border-radius: 10px;
  padding: 30px 40px;
}

.wrapper h2{
  font-size: 36px;
  text-align: center;
}

.wrapper .input-box{
  position: relative;
  width: 100%;
  height: 50px;
  margin: 30px 0;
}

.input-box input {
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, .2);
  border-radius: 40px;
  font-size: 16px;
  color: #fff;
  padding: 20px 45px 20px 20px;
}

.input-box input::placeholder{
  color: #fff;
}

.input-box i {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
}

.wrapper .remember-forget{
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}

.remember-forget label input{
  accent-color: #fff;
  margin-right: 3px;
}

.remember-forget a {
  color: #fff;
  text-decoration: none;
}

.remember-forget a:hover{
  text-decoration: underline;
}

.wrapper .btn{
  width: 100%;
  height: 45px;
  background: #fff;
  border: none;
  outline: none;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, .1);
  cursor: pointer;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}

.wrapper .register-link{
  font-size: 14.5px;
  text-align: center;
  margin: 20px 0 15px;
}

.register-link p a{
  color: #fff;
  text-decoration: none;
  font-weight: 600;
}

.register-link p a:hover{
  text-decoration: underline;
}

.custom_error {
  margin-left: 20px;
}

.error{
  color: red;
}
</style>