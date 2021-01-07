<template>
    <div>

        <div class="form-group row">
            <label for="element_description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="element_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="elementForm.description">
                <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has('description')" v-text="elementForm.errors.get('description')"></span>
            </div>
        </div>
        <div class="form-group">
        </div>

    </div>
</template>

<script>
    export default {
        name: "fields"
    }
</script>

<style scoped>

</style>
