<template>
    <div>
        <div class="row my-5" v-if="!isLoggedIn">
            <div class="col-6 offset-3">
                <div class="card">
                    <p class="card-header h3 text-center">Login</p>
                    <div class="card-body">
                        <form action="#" @submit.prevent="login">
                            <div class="form-group form-row">
                                <input type="email" name="email" id="email" class="form-control" v-model="formData.email" placeholder="Email">
                            </div>
                            <div class="form-group form-row">
                                <input type="password" name="password" id="password" class="form-control" v-model="formData.password" placeholder="Password">
                            </div>
                            <div class="form-group form-row">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5" v-if="isLoggedIn">
            <button class="btn btn-primary" @click="getUser">Get User</button>
            <button class="btn btn-primary" @click="logout">Logout</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoggedIn: localStorage.getItem('isLoggedIn') == 'true',
                formData: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            login() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData).then(response => {
                        localStorage.setItem('isLoggedIn', 'true');
                        this.isLoggedIn = true;
                    });
                });
            },
            logout() {
                axios.post('/logout').then(response => {
                    localStorage.removeItem('isLoggedIn', 'true');
                    this.isLoggedIn = false;
                });
            },
            getUser() {
                axios.get('/api/user').then(response => {
                    console.log(response);
                });
            }
        }
    }
</script>
