<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Créer Nouvel Elements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/elements">Elements</a></li>
                            <li class="breadcrumb-item active">Creer/Modifier Element</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1"> Céer Nouvel Elément </span>
                        </div>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <!--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">-->

                                <!--<div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->


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
                                    <div class="col-sm-10" v-if="attribut.valuetype.code === 'string_value' || attribut.valuetype.code === 'biginteger_value' || attribut.valuetype.code === 'integer_value'">
                                        <input type="text" class="form-control" :id="attribut.uuid" :name="attribut.uuid" :placeholder="attribut.nom" v-model="elementForm[attribut.uuid]">
                                        <span class="invalid-feedback d-block" role="alert" v-if="elementForm.errors.has(`${attribut.nom}`)" v-text="elementForm.errors.get(`${attribut.nom}`)"></span>
                                    </div>
                                    <div class="col-sm-10" v-else-if="attribut.valuetype.code === 'boolean_value'">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" :id="attribut.uuid" :name="attribut.uuid" :placeholder="attribut.nom" v-model="elementForm[attribut.uuid]">
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
                        <button type="button" class="btn btn-warning btn-sm" @click="createElement()" :disabled="!isValidCreateForm">Valider</button>
                    </div>

                    <!-- /.card-body -->

                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
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
        name: "createElement",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_new_element', () => {
                this.editing = false
                //this.element = new Element({})
                this.elementForm = new Form({})
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
                selectedtype: {}
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
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
