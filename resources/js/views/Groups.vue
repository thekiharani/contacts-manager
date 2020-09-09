<template>
    <!-- groups list -->
    <div class="table-responsive">
        <p class="h3 text-center">My Groups</p>
        <div v-if="store || !groups.length">
            <GroupForm :formAction="storeGroup" :cancel="() => {store = false; action = ''}" :formData="formData" title="New Group" />
        </div>
        <div v-if="groups.length">
            <div class="form-group" v-if="!store">
                <div class="row">
                    <div class="col-12">
                        <label for="action">Choose Action, then select Groups to Apply</label>
                    </div>
                    <div class="col-lg-9">
                        <select name="action" id="action" class="form-control" v-model="action" @change="getAction($event)">
                            <option value="">-- Select Action --</option>
                            <option value="send_message">Send Message</option>
                            <option value="add_contacts">Add to Contacts</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-lg-3" v-if="action === 'delete' && checkedGroups.length" >
                        <button class="btn btn-danger btn-block" @click="deleteGroups">Delete</button>
                    </div>
                    <div class="col-lg-3" v-if="action === '' || !checkedGroups.length">
                        <button class="btn btn-primary px-3" @click="() => store = true">Add Group</button>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="group in groups" :key="group.id">
                        <td>
                            <div class="form-check text-center">
                                <input :id="group.id" :value="group.id" name="checked_groups" type="checkbox" v-model="checkedGroups" />
                            </div>
                        </td>
                        <td>{{ group.name }}</td>
                        <td>{{ group.date_created }}</td>
                        <td>
                            <router-link class="btn btn-primary"  to="group_message">Send Message</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>

            <!-- Text box for send message action -->
            <div class="row my-3" v-if="action === 'send_message' && checkedGroups.length">
                <div class="col-lg-6 offset-3">
                    <label for="message_body">Message</label>
                    <textarea v-model="message_body" name="message_body" id="message_body" class="form-control" rows="5" placeholder="Compose Message"></textarea>

                    <button class="btn btn-primary btn-block mt-3" @click="sendGroupSms">Send</button>
                </div>
            </div>

            <!-- Text box for add contacts action -->
            <div class="my-3" v-if="action === 'add_contacts' && checkedGroups.length">
                <p class="h5">Select Contacts to Add</p>
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
                <div class="form-group" v-if="checkedContacts.length">
                    <button class="btn btn-primary btn-block" @click="attachContactsGroups">Add Contacts</button>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import GroupForm from "../components/GroupForm";
    export default {
        components: {GroupForm},
        data() {
            return {
                action: '',
                store: false,
                checkedGroups: [],
                checkedContacts: [],
                groups: [],
                contacts: [],
                message_body: '',
                formData: {
                    name: '',
                    description: ''
                }
            }
        },
        beforeMount() {
          this.getGroups();
        },
        methods: {
            getGroups() {
                axios.get('/api/groups').then(response => {
                    console.log(response);
                    this.groups = response.data;
                })
            },

            getContacts() {
                axios.get('/api/contacts').then(response => {
                    console.log(response);
                    this.contacts = response.data;
                })
            },

            storeGroup() {
                axios.post('/api/groups', this.formData).then(response => {
                    console.log(response);
                    this.groups.unshift(response.data.group);
                    this.formData.name = '';
                    this.formData.description = '';
                    this.store =false;
                });
            },

            sendGroupSms() {
                axios.post('/api/group_sms', {'groups': this.checkedGroups, 'message': this.message_body}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedContacts = [];
                    this.message_body = '';
                });
            },

            attachContactsGroups() {
                axios.post('/api/contacts_groups', {'contacts': this.checkedContacts, 'groups': this.checkedGroups}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedContacts = [];
                    this.checkedGroups = [];
                });
            },

            deleteGroups() {
                // Can't do delete since an array is passed as a param
                axios.post('/api/delete_groups', {'groups': this.checkedGroups}).then(response => {
                    console.log(response);
                    this.action = '';
                    this.checkedGroups = [];
                    this.getGroups();
                });
            },

            getAction(e) {
                this.checkedGroups = [];
                this.action = e.target.value;
                if (e.target.value === 'add_contacts') {
                    this.getContacts();
                }
                console.log(e.target.value)
            }
        }
    }
</script>
