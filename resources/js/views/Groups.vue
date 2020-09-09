<template>
    <!-- groups list -->
    <div class="table-responsive">
        <p class="h3 text-center">My Groups</p>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="group in groups" :key="group.id">
                    <td>{{ group.name }}</td>
                    <td>{{ group.date_created }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                groups: [],
                formData: {
                    email: '',
                    password: ''
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
            }
        }
    }
</script>
