<template>
    <!-- contacts list -->
    <div class="table-responsive">
        <p class="h3 text-center">Personal Message</p>
        <hr>

        <form @submit.prevent="" class="form-row">
            <div class="form-group col-lg-6 offset-3">
                <label for="group">Change Contacts</label>
                <select name="group" id="group" class="form-control" multiple>
                    <option v-for="(contact, i) in contacts" :key="`${i}-${contact.id}`" v-bind:value="contact.id">{{ contact.name }}</option>
                </select>
            </div>

            <div class="form-group col-lg-6 offset-3">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="form-control" rows="5" placeholder="Compose Message"></textarea>
            </div>

            <div class="form-group col-lg-6 offset-3">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contacts: [],
                formData: {
                    message: '',
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
            }
        }
    }
</script>
