<template>
    <div class="modal fade" id="addUpdateAttribut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Attribut</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouvel Attribut</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="attributForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="attribut_nom" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="attribut_nom" name="nom" autocomplete="nom" autofocus placeholder="Nom" v-model="attributForm.nom">
                                    <span class="invalid-feedback d-block" role="alert" v-if="attributForm.errors.has('nom')" v-text="attributForm.get('nom')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_attribut_typevalue" class="col-sm-2 col-form-label">Type Valeur</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_attribut_typevalue"
                                        v-model="attributForm.valuetype"
                                        selected.sync="attributForm.valuetype"
                                        value=""
                                        :options="valuetypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="nom"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type Valeur"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="attributForm.errors.has('valuetype')" v-text="attributForm.errors.get('valuetype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="attribut_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="attribut_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="attributForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="attributForm.errors.has('description')" v-text="attributForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="attribut_obligatoire" name="obligatoire" autocomplete="obligatoire" autofocus placeholder="Obligatoire ?" v-model="attributForm.obligatoire">
                                    <label class="form-check-label" for="attribut_obligatoire">Champs Requis ?</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="attributForm.errors.has('obligatoire')" v-text="attributForm.errors.get('obligatoire')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="attribut_est_libelle" name="est_libelle" autocomplete="est_libelle" autofocus placeholder="Participe au Libellé ?" v-model="attributForm.est_libelle">
                                    <label class="form-check-label" for="attribut_est_libelle">Participe au Libellé ?</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="attributForm.errors.has('est_libelle')" v-text="attributForm.errors.get('est_libelle')"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateAttribut(typeelementId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createAttribut(typeelementId)" :disabled="!isValidCreateForm" v-else>Créer Attribut</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import AttributBus from './attributBus'

    class Attribut {
        constructor(attribut) {
            this.nom = attribut.nom || ''
            this.obligatoire = attribut.obligatoire || ''
            this.est_libelle = attribut.est_libelle || ''
            this.description = attribut.description || ''
            this.type_element_id = attribut.type_element_id || ''
            this.valuetype = attribut.valuetype || ''
        }
    }
    export default {
        name: "addupdateAttribut",
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_attribut', (typeelementId) => {
                this.editing = false
                this.typeelementId = typeelementId
                this.attribut = new Attribut({})
                this.attribut.type_element_id = typeelementId
                this.attributForm = new Form(this.attribut)
                $('#addUpdateAttribut').modal()
            })
            AttributBus.$on('edit_attribut', (attribut, typeelementId) => {
                this.editing = true
                this.attribut = new Attribut(attribut)
                this.attributForm = new Form(this.attribut)
                this.attributId = attribut.uuid
                this.typeelementId = typeelementId
                $('#addUpdateAttribut').modal()
            })
        },
        created() {
            axios.get('/attributvaluetypes.fetch')
                .then(({data}) => this.valuetypes = data);
        },
        data() {
            return {
                attribut: {},
                typeelementId: '',
                attributForm: new Form(new Attribut({})),
                attributId: null,
                editing: false,
                loading: false,
                valuetypes: []
            }
        },
        methods: {
            createAttribut(typeelementId) {
                this.loading = true
                this.attributForm
                    .post('/attributs')
                    .then(attribut => {
                        this.loading = false
                        //this.$parent.$emit('new_elementattribut_created', newelementattribut, this.elementId)
                        AttributBus.$emit('attribut_created', {attribut, typeelementId})
                        $('#addUpdateAttribut').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateAttribut(typeelementId) {
                this.loading = true
                const fd = this.addFileToForm()
                this.attributForm
                    .put(`/attributs/${this.attributId}`, fd)
                    .then(attribut => {
                        this.loading = false
                        //let elementId = this.elementId
                        AttributBus.$emit('attribut_updated', {attribut, typeelementId})
                        $('#addUpdateAttribut').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm() {
                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append('attribut_files', this.selectedFile);
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
