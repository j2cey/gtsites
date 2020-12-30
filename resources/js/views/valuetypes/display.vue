<template>
    <small>
        <span class="text-lighter hidden-sm-down">
            <span v-if="valuetype.code === 'string_value'" class="badge badge-pill badge-light">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'biginteger_value'" class="badge badge-pill badge-secondary">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'integer_value'" class="badge badge-pill badge-secondary">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'binary_value'" class="badge badge-pill badge-success">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'boolean_value'" class="badge badge-pill badge-danger">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'datetime_value'" class="badge badge-pill badge-warning">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'ipaddress_value'" class="badge badge-pill badge-info">{{valuetype.nom}}</span>
            <span v-else-if="valuetype.code === 'json_value'" class="badge badge-pill badge-info">{{valuetype.nom}}</span>
            <span v-else class="badge badge-pill badge-dark">{{valuetype.nom}}</span>
        </span>
    </small>
</template>

<script>
    export default {
        name: "valuetypedisplay",
        props: {
            valuetype_prop: {}
        },
        data() {
            return {
                //valuetype: this.valuetype_prop
            };
        },
        computed: {
            valuetype() {
                return this.valuetype_prop;
            }
        },
    }
</script>

<style scoped>

</style>
