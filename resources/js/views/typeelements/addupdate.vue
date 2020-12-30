<template>
    <div class="modal fade" id="addUpdateTypeElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Type Element</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouveau Type Element</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="typeelementForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="typeelement_nom" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="typeelement_nom" name="nom" autocomplete="nom" autofocus placeholder="Titre" v-model="typeelementForm.nom">
                                    <span class="invalid-feedback d-block" role="alert" v-if="typeelementForm.errors.has('nom')" v-text="typeelementForm.errors.get('nom')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="typeelement_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="typeelement_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="typeelementForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="typeelementForm.errors.has('description')" v-text="typeelementForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateTypeElement()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createTypeElement()" :disabled="!isValidCreateForm" v-else>Créer Element</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    class TypeElement {
        constructor(typeelement) {
            this.nom = typeelement.nom || ''
            this.description = typeelement.description || ''
        }
    }
    export default {
        name: "addupdateTypeElement",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_typeelement', () => {
                this.editing = false
                this.typeelement = new TypeElement({})
                this.typeelementForm = new Form(this.typeelement)
                $('#addUpdateTypeElement').modal()
            })
            this.$parent.$on('edit_typeelement', ({ typeelement }) => {
                this.editing = true
                this.typeelement = new TypeElement(typeelement)
                this.typeelementForm = new Form(this.typeelement)
                this.typeelementId = typeelement.uuid
                $('#addUpdateTypeElement').modal()
            })
        },
        created() {
            axios.get('/typeelements.fetch')
                .then(({data}) => this.subtypeelements = data);
        },
        data() {
            return {
                typeelement: {},
                typeelementForm: new Form(new TypeElement({})),
                typeelementId: null,
                editing: false,
                loading: false,
                subtypeelements: []
            }
        },
        methods: {
            createTypeElement() {
                this.loading = true
                this.typeelementForm
                    .post('/typeelements')
                    .then(typeelement => {
                        this.loading = false
                        this.$parent.$emit('typeelement_created', typeelement)
                        $('#addUpdateTypeElement').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateTypeElement() {
                this.loading = true
                this.typeelementForm
                    .put(`/typeelements/${this.typeelementId}`,undefined)
                    .then(typeelement => {
                        this.loading = false
                        this.$parent.$emit('typeelement_updated', typeelement)
                        $('#addUpdateTypeElement').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
