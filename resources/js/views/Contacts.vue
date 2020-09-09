<template>
    <!-- contacts list -->
    <div class="table-responsive">
        <p class="h3 text-center">My Contacts</p>
        <hr>
        <Form :formAction="addContact" :formData="formData" title="New Contact" />

        <table class="table table-bordered" v-if="contacts.length">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(contact, i) in contacts" :key="`${i}-${contact.id}`">
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.phone_number }}</td>
                    <td>{{ contact.date_created }}</td>
                    <td>
                        <button class="btn btn-primary" @click="viewContact(contact.id)">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <p class="text-danger text-center">You do not have contacts yet...</p>
        </div>
    </div>
</template>

<script>
    import Form from "../components/Form";
    export default {
        components: {Form},
        data() {
            return {
                updating: false,
                edit_contact: {},
                contacts: [],
                formData: {
                    name: '',
                    phone_number: ''
                }
            }
        },
        beforeMount() {
          this.getContacts();
        },
        methods: {
            getContacts() {
                axios.get('/api/contacts').then(response => {
                    console.log(response);
                    this.contacts = response.data;
                })
            },
            addContact() {
                axios.post('/api/contacts', this.formData).then(response => {
                    console.log(response);
                    this.contacts.unshift(response.data.contact);
                    this.formData.name = '';
                    this.formData.phone_number = '';
                });
            },
            viewContact(contact_id) {
                axios.get(`/api/contacts/${contact_id}`).then(response => {
                    console.log(response);
                    this.updating = true;
                    this.edit_contact = response.data;
                    this.formData.name = response.data.name;
                    this.formData.phone_number = `0${response.data.phone_number.substring(4, 13)}`;
                })
            },
            updateContact(contact_id) {
                axios.put(`/api/contacts/${contact_id}`, this.formData).then(response => {
                    // this.contacts.pop(contact);
                    console.log(response);
                    this.formData.name = '';
                    this.formData.phone_number = '';
                });
            }
        }
    }
</script>
