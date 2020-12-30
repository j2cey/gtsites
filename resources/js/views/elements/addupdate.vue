<template>
    <div class="modal fade" id="addUpdateElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                    <form class="form-horizontal" @submit.prevent @keydown="elementForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="element_nom" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="element_nom" name="nom" autocomplete="nom" autofocus placeholder="Titre" v-model="elementForm.nom">
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has('nom')" v-text="elementForm.errors.get('nom')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_element_parent" class="col-sm-2 col-form-label">Parent</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_element_parent"
                                        v-model="elementForm.elementparent"
                                        selected.sync="elementForm.elementparent"
                                        value=""
                                        :options="elementparents"
                                        :searchable="true"
                                        :multiple="false"
                                        label="nom"
                                        track-by="id"
                                        key="id"
                                        placeholder="Parent"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has('elementparent')" v-text="elementForm.errors.get('elementparent')"></span>
                                </div>
                            </div>
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
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateElement()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createElement()" :disabled="!isValidCreateForm" v-else>Créer Element</button>
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
            this.nom = element.nom || ''
            this.elementparent = element.elementparent || ''
            this.description = element.description || ''
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
            axios.get('/elements.fetch')
                .then(({data}) => this.elementparents = data);
        },
        data() {
            return {
                element: {},
                elementForm: new Form(new Element({})),
                elementId: null,
                editing: false,
                loading: false,
                elementparents: []
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
