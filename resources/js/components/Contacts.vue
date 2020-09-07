<template>
    <div>
        <!-- login form -->
        <div class="row my-5" v-if="!contacts.length">
            <div class="col-6 offset-3">
                <div class="card">
                    <p class="card-header h3 text-center">Login</p>
                    <div class="card-body">
                        <form action="#" @submit.prevent="handleLogin">
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
        <!-- contacts list -->
        <button class="btn btn-success" @click="this.getContacts">Load Contacts</button>
        <div class="row" v-if="contacts.length">
            <div class="col-6 offset-3">
                <div class="card">
                    <p class="card-header h3 text-center">My Contacts</p>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="contact in contacts" :key="contact.id">
                                <em v-text="contact.created_at"></em> <br>
                                <strong v-text="contact.name"></strong> - <strong v-text="contact.phone_number"></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contacts: [],
                formData: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            handleLogin() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData).then(response => {
                        this.getContacts();
                    });
                });
            },
            getContacts() {
                axios.get('/api/contacts').then(response => {
                    console.log(response);
                    this.contacts = response.data;
                })
            }
        }
    }
</script>
