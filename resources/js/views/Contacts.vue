<template>
    <!-- contacts list -->
    <div class="table-responsive">
        <p class="h3 text-center">My Contacts</p>
        <hr>
        <!-- Show contact creation form -->
        <div v-if="store || !contacts.length">
            <ContactForm :formAction="storeContact" :cancel="() => {store = false; action = ''}" :formData="formData" title="New Contact" />
        </div>
        <div v-if="contacts.length">
            <div class="form-group" v-if="!store">
                <div class="row">
                    <div class="col-12">
                        <label for="action">Choose Action, then select Contacts to Apply</label>
                    </div>
                    <div class="col-lg-9">
                        <select name="action" id="action" class="form-control" v-model="action" @change="getAction($event)">
                            <option value="">-- Select Action --</option>
                            <option value="send_message">Send Message</option>
                            <option value="add_group">Add to Group</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-lg-3" v-if="action === 'delete' && checkedContacts.length" >
                        <button class="btn btn-danger btn-block" @click="deleteContacts">Delete</button>
                    </div>
                    <div class="col-lg-3" v-if="action === '' || !checkedContacts.length">
                        <button class="btn btn-primary px-3" @click="() => store = true">Add Contact</button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(contact, i) in contacts" :key="`${i}-${contact.id}`">
                        <td>
                            <div class="form-check text-center">
                                <input :id="contact.id" :value="action === 'send_message' ? contact.phone_number : contact.id" name="checked_contacts" type="checkbox" v-model="checkedContacts" />
                            </div>
                        </td>
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phone_number }}</td>
                        <td>{{ contact.date_created }}</td>
                    </tr>
                </tbody>
            </table>
            <hr>

            <!-- Text box for send message action -->
            <div class="row my-3" v-if="action === 'send_message' && checkedContacts.length">
                <div class="col-lg-6 offset-3">
                    <label for="message_body">Message</label>
                    <textarea v-model="message_body" name="message_body" id="message_body" class="form-control" rows="5" placeholder="Compose Message"></textarea>

                    <button class="btn btn-primary btn-block mt-3" @click="sendPersonalSms">Send</button>
                </div>
            </div>

            <!-- Group selection action -->
            <div class="row my-3" v-if="action === 'add_group' && checkedContacts.length">
                <div class="col-lg-6 offset-3">
                    <label for="group">Select Group</label>
                    <select v-model="group" name="group" id="group" class="form-control">
                        <option value="">-- Select Group--</option>
                        <option v-for="(group, i) in groups" :key="`${i}-${group.id}`" v-bind:value="group.id">{{ group.name }}</option>
                    </select>

                    <button class="btn btn-primary btn-block mt-3" @click="attachGroupContacts">Add Contacts</button>
                </div>
            </div>
        </div>

        <div v-else>
            <p class="text-danger text-center">You do not have contacts yet...</p>
        </div>
    </div>
</template>

<script>
    import ContactForm from "../components/ContactForm";
    export default {
        components: {ContactForm},
        data() {
            return {
                action: '',
                store: false,
                edit_contact: {},
                contacts: [],
                groups: [],
                checkedContacts: [],
                message_body: '',
                group: '',
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

            getGroups() {
                axios.get('/api/groups').then(response => {
                    console.log(response);
                    this.groups = response.data;
                })
            },

            storeContact() {
                axios.post('/api/contacts', this.formData).then(response => {
                    console.log(response);
                    this.contacts.unshift(response.data.contact);
                    this.formData.name = '';
                    this.formData.phone_number = '';
                    this.store =false;
                });
            },

            sendPersonalSms() {
                axios.post('/api/personal_sms', {'contacts': this.checkedContacts, 'message': this.message_body}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedContacts = [];
                    this.message_body = '';
                });
            },

            attachGroupContacts() {
                axios.post('/api/group_contacts', {'contacts': this.checkedContacts, 'group': this.group}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedContacts = [];
                    this.group = '';
                });
            },

            deleteContacts() {
                // Can't do delete since an array is passed as a param
                axios.post('/api/delete_contacts', {'contacts': this.checkedContacts}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedContacts = [];
                    this.getContacts();
                });
            },

            getAction(e) {
                this.checkedContacts = [];
                this.action = e.target.value;
                if (e.target.value === 'add_group') {
                    this.getGroups();
                }
                console.log(e.target.value)
            }
        }
    }
</script>
