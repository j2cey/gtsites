<template>
    <div class="modal fade" id="addUpdateElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Type Element</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouvel Element</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="elementForm.errors.clear()">

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="m_select_type_element" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_type_element"
                                        v-model="elementForm.typeelement"
                                        selected.sync="elementForm.typeelement"
                                        value=""
                                        :options="typeelements"
                                        :searchable="true"
                                        :multiple="false"
                                        label="nom"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type"

                                        :preselect-first="true"
                                        @select="selectedTypeChange"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has('typeelement')" v-text="elementForm.errors.get('typeelement')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-for="(attribut, index) in selectedType.attributs" v-if="selectedType.attributs">

                                <div v-if="attribut.valuetype.est_compose" class="col-sm-10">
                                    <multiselect
                                        :id="attribut.valuetype.uuid"
                                        v-model="elementForm[attribut.uuid]"
                                        selected.sync="elementForm[attribut.uuid]"
                                        value=""
                                        :options="composedvaluetypes[attribut.valuetype.id]"
                                        :searchable="true"
                                        :multiple="false"
                                        label="label"
                                        track-by="id"
                                        key="id"
                                        :placeholder="attribut.nom"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has('typeelement')" v-text="elementForm.errors.get('typeelement')"></span>
                                </div>

                                <div class="col-sm-10" v-else-if="attribut.valuetype.code === 'string_value'">
                                    <input type="text" class="form-control" :id="attribut.uuid" :name="attribut.uuid" :placeholder="attribut.nom + ' (chaine caractères)'" v-model="elementForm[attribut.uuid]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has(`${attribut.nom}`)" v-text="elementForm.errors.get(`${attribut.nom}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="attribut.valuetype.code === 'biginteger_value' || attribut.valuetype.code === 'integer_value'">
                                    <input type="text" class="form-control" :id="attribut.uuid" :name="attribut.uuid" :placeholder="attribut.nom + ' (entier)'" v-model="elementForm[attribut.uuid]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has(`${attribut.nom}`)" v-text="elementForm.errors.get(`${attribut.nom}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="attribut.valuetype.code === 'boolean_value'">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :id="attribut.uuid" :name="attribut.uuid" :placeholder="attribut.nom + ' (booléen)'" v-model="elementForm[attribut.uuid]">
                                        <label class="form-check-label" :for="attribut.uuid">{{ attribut.nom }}</label>
                                        <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has(`${attribut.uuid}`)" v-text="elementForm.errors.get(`${attribut.uuid}`)"></span>
                                    </div>
                                </div>
                                <div class="col-sm-10" v-else-if="attribut.valuetype.code === 'datetime_value'">
                                    <VueCtkDateTimePicker v-model="elementForm[attribut.uuid]" :label="attribut.nom" format="YYYY-MM-DD hh:mm:ss" />
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has(`${attribut.nom}`)" v-text="elementForm.errors.get(`${attribut.nom}`)"></span>
                                </div>

                                <div class="col-sm-10" v-else>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateElement()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="createElement()" :disabled="!isValidCreateForm" v-else>Créer Element</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    class Element {
        constructor(element) {
            this.typeelement = element.typeelement || ''
        }
    }
    export default {
        name: "addupdateElement",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_new_element', () => {
                this.editing = false
                this.element = new Element({})
                this.elementForm = new Form(this.element)
                $('#addUpdateElement').modal()
            })
            this.$parent.$on('edit_element', ({ element }) => {
                this.editing = true
                this.element = new Element(element)
                this.elementForm = new Form(this.element)
                this.elementId = element.uuid
                $('#addUpdateElement').modal()
            })
        },
        created() {
            axios.get('/typeelements.fetch')
                .then(({data}) => this.typeelements = data);

            axios.get('/attributvaluetypes/fetchcomposedall')
                .then(({data}) => this.composedvaluetypes = data);
        },
        data() {
            return {
                element: {},
                attributvalues: [],
                elementForm: new Form({}), // "typeelement": {} ,"attributvalues": []
                elementId: null,
                editing: false,
                loading: false,
                typeelements: [],
                selectedtype: {},
                composedvaluetypes: []
            }
        },
        methods: {
            createElement() {
                this.loading = true
                this.elementForm
                    .post('/elements')
                    .then(newelement => {
                        this.loading = false
                        this.$parent.$emit('new_element_created', newelement)
                        $('#addUpdateElement').modal('hide')
                        window.noty({
                            message: 'Element créé avec succès',
                            type: 'success'
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateElement() {
                this.loading = true
                this.elementForm
                    .put(`/elements/${this.elementId}`,undefined)
                    .then(updelement => {
                        this.loading = false
                        this.$parent.$emit('element_updated', updelement)
                        $('#addUpdateElement').modal('hide')
                        window.noty({
                            message: 'Element modifié avec succès',
                            type: 'success'
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            selectedTypeChange(selectedtype) {
                this.initNewForm(selectedtype);
            },
            initNewForm(selectedtype) {
                //console.log(selectedtype)
                this.selectedtype = selectedtype

                this.attributvalues = [];

                this.attributvalues['type_element_id'] = selectedtype.id; //JSON.stringify(selectedtype);
                this.selectedtype.attributs.forEach((value, index) => {
                    this.attributvalues[value.uuid] = null;
                });
                this.elementForm = new Form( this.attributvalues )
                console.log("selected type:", selectedtype);
                console.log("elementForm:", this.elementForm);
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading// && (this.selectedtype.length > 0)
            },
            selectedType() {
                return this.selectedtype
            },
            composedValueTypes() {
                return this.composedvaluetypes;
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
