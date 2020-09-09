<template>
    <!-- groups list -->
    <div class="table-responsive">
        <p class="h3 text-center">My Groups</p>
        <GroupForm :formAction="addGroup" :formData="formData" title="New Group" />
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="group in groups" :key="group.id">
                    <td>{{ group.name }}</td>
                    <td>{{ group.date_created }}</td>
                    <td>
                        <router-link class="btn btn-primary"  to="group_message">Send Message</router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import GroupForm from "../components/GroupForm";
    export default {
        components: {GroupForm},
        data() {
            return {
                groups: [],
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
            addGroup() {
                axios.post('/api/groups', this.formData).then(response => {
                    console.log(response);
                    this.groups.unshift(response.data.group);
                    this.formData.name = '';
                    this.formData.description = '';
                });
            },
        }
    }
</script>
