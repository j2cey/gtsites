<template>
    <div class="modal fade" id="addUpdateSubtypeElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Sous-Type</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouveau Sous-Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="subtypeelementForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="subtypeelement_nom" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="subtypeelement_nom" name="nom" autocomplete="nom" autofocus placeholder="Nom" v-model="subtypeelementForm.nom">
                                    <span class="invalid-feedback d-block" role="alert" v-if="subtypeelementForm.errors.has('nom')" v-text="subtypeelementForm.get('nom')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_subtypeelement_subtype" class="col-sm-2 col-form-label">Type Elément</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_subtypeelement_subtype"
                                        v-model="subtypeelementForm.subtype"
                                        selected.sync="subtypeelementForm.subtype"
                                        value=""
                                        :options="subtypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="nom"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type Elément"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="subtypeelementForm.errors.has('subtype')" v-text="subtypeelementForm.errors.get('subtype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subtypeelement_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="subtypeelement_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="subtypeelementForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="subtypeelementForm.errors.has('description')" v-text="subtypeelementForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="subtypeelement_obligatoire" name="obligatoire" autocomplete="obligatoire" autofocus placeholder="Obligatoire ?" v-model="subtypeelementForm.obligatoire">
                                    <label class="form-check-label" for="subtypeelement_obligatoire">Champs Requis ?</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="subtypeelementForm.errors.has('obligatoire')" v-text="subtypeelementForm.errors.get('obligatoire')"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateSubtypeElement(typeelementId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createSubtypeElement(typeelementId)" :disabled="!isValidCreateForm" v-else>Créer Sous-Type</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import SubtypeelementBus from './subtypeelementBus'

    class SubtypeElement {
        constructor(subtypeelement) {
            this.nom = subtypeelement.nom || ''
            this.obligatoire = subtypeelement.obligatoire || ''
            this.description = subtypeelement.description || ''
            this.type_element_id = subtypeelement.type_element_id || ''
            this.subtype = subtypeelement.subtype || ''
        }
    }
    export default {
        name: "addupdateSubtypeElement",
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_subtypeelement', (typeelementId) => {
                this.editing = false
                this.typeelementId = typeelementId
                this.subtypeelement = new SubtypeElement({})
                this.subtypeelement.type_element_id = typeelementId
                this.subtypeelementForm = new Form(this.subtypeelement)
                $('#addUpdateSubtypeElement').modal()
            })
            SubtypeelementBus.$on('edit_subtypeelement', (subtypeelement, typeelementId) => {
                this.editing = true
                this.subtypeelement = new SubtypeElement(subtypeelement)
                this.subtypeelementForm = new Form(this.subtypeelement)
                this.subtypeelementId = subtypeelement.uuid
                this.typeelementId = typeelementId
                $('#addUpdateSubtypeElement').modal()
            })
        },
        created() {
            axios.get('/typeelements.fetch')
                .then(({data}) => this.subtypes = data);
        },
        data() {
            return {
                subtypeelement: {},
                typeelementId: '',
                subtypeelementForm: new Form(new SubtypeElement({})),
                subtypeelementId: null,
                editing: false,
                loading: false,
                subtypes: []
            }
        },
        methods: {
            createSubtypeElement(typeelementId) {
                this.loading = true
                this.subtypeelementForm
                    .post('/subtypeelements')
                    .then(subtypeelement => {
                        this.loading = false
                        //this.$parent.$emit('new_elementsubtypeelement_created', newelementsubtypeelement, this.elementId)
                        SubtypeelementBus.$emit('subtypeelement_created', {subtypeelement, typeelementId})
                        $('#addUpdateSubtypeElement').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateSubtypeElement(typeelementId) {
                this.loading = true
                const fd = this.addFileToForm()
                this.subtypeelementForm
                    .put(`/subtypeelements/${this.subtypeelementId}`, fd)
                    .then(subtypeelement => {
                        this.loading = false
                        //let elementId = this.elementId
                        SubtypeelementBus.$emit('subtypeelement_updated', {subtypeelement, typeelementId})
                        $('#addUpdateSubtypeElement').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm() {
                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append('subtypeelement_files', this.selectedFile);
                    //console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    //console.log("image not added", fd);
                    return fd;
                }
            },
        },
        computed: {
            roles_comp() {
                return this.roles;
            },
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
