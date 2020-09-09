<template>
    <!-- contacts list -->
    <div class="table-responsive">
        <p class="h3 text-center">Group Message</p>
        <hr>

        <form @submit.prevent="" class="form-row">
            <div class="form-group col-lg-6 offset-3">
                <label for="group">Change Group</label>
                <select name="group" id="group" class="form-control">
                    <option v-for="(group, i) in groups" :key="`${i}-${group.id}`" v-bind:value="group.id">{{ group.name }}</option>
                </select>
            </div>

            <div class="form-group col-lg-6 offset-3">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="form-control" rows="5" placeholder="Compose Message"></textarea>
            </div>

            <div class="form-group col-lg-6 offset-3">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Send</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                groups: [],
                formData: {
                    message: '',
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
