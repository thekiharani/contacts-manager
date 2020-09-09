<template>
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
</template>

<script>
    export default {
        name: "ContactList",
        props: {
            contacts: {
                type: Array
            },
            checkedContacts: {
                type: Array
            },
            action: {
                type: String
            }
        }
    }
</script>
