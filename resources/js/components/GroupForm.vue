<template>
    <div class="form-group">
        <p class="h4">{{ title }}</p>
        <form action="#" class="form-row" @submit.prevent="formAction">
            <div class="col-lg-5">
                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" v-model="formData.name" />
            </div>
            <div class="col-lg-5">
                <input type="text" name="description" id="description" class="form-control" placeholder="Optional Group description" v-model="formData.description" />
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "GroupForm",
        props: {
            formAction: {
                type: Function
            },
            formData: {
                type: Object
            },
            title: {
                String
            }
        }
    }
</script>
