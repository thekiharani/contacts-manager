<template>
    <div class="form-group">
        <p class="h5">{{ title }}</p>
        <form action="#" class="form-row" @submit.prevent="formAction">
            <div class="col-lg-4">
                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" v-model="formData.name" />
            </div>
            <div class="col-lg-4">
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="10 Digits Phone Number: 07xxxxxxxx" v-model="formData.phone_number" />
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger btn-block" @click="cancel">Cancel</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "ContactForm",
        props: {
            formAction: {
                type: Function
            },
            cancel: {
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
