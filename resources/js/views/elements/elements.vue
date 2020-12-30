<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Elements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Elements</li>
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
                            <span class="help-inline pr-1"> Liste de Types Elements </span>
                            <button class="btn btn-xs btn-primary" @click="createNewElement()">Nouveau</button>
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
                    <div class="card-body">
                        <div id="elementlist">

                            <div class="card card-widget" v-for="(element, index) in elements" v-if="elements">
                                <div class="card-header">
                                    <div class="user-block">
                                        <span class="text-purple" data-toggle="collapse" data-parent="#elementlist" :href="'#collapse-elements-'+index">
                                            {{ element.nom }}
                                        </span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editElement(element)">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#elementlist" :href="'#collapse-elements-'+index"><i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" @click="deleteElement(element.uuid, index)"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div :id="'collapse-elements-'+index" class="panel-collapse collapse in">
                                    <div class="card-body" >

                                        <div class="row">
                                            <div class="col-md-12 col-sm-6 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <dt>Parent</dt>
                                                        <dd>{{ element.elementparent ? element.elementparent.nom : '' }}</dd>
                                                        <dt>Description</dt>
                                                        <dd>{{ element.description }}</dd>
                                                        <dt>Date Création</dt>
                                                        <dd>{{ element.created_at | formatDate}}</dd>
                                                        <dd class="col-sm-8 offset-sm-4"></dd>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-md-12 col-sm-6 col-12">

                                                <div class="card card-default">
                                                    <div class="card-header">
                                                        <div class="form-inline float-left">
                                                            <span class="help-inline pr-1"> Attribut(s) </span>
                                                            <button class="btn btn-xs btn-primary" @click="createNewAttribut(element.id)">Nouvel</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <Attributs :elementId="element.id" :attributs_prop="element.attributs"></Attributs>
                                                        </div>

                                                    </div>
                                                    <!-- /.card-body -->

                                                </div>

                                            </div>
                                            <!-- /.col -->

                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <AddUpdateElement></AddUpdateElement>
        <AddUpdateAttribut></AddUpdateAttribut>
    </div>
</template>

<script>
    import AddUpdateElement from './addupdate'
    import AddUpdateAttribut from './../attributs/addupdate'
    import Attributs from './../attributs/attributs'

    export default {
        name: "elements",
        mounted() {
            this.$on('new_element_created', (element) => {
                window.noty({
                    message: 'Type Element créé avec succès',
                    type: 'success'
                })
                // insert la nouvelle element dans le tableau des elements
                this.elements.push(element)
            })
            this.$on('element_updated', (element) => {
                // on récupère l'index de la element modifiée
                let elementIndex = this.elements.findIndex(c => {
                    return element.id === c.id
                })
                this.elements.splice(elementIndex, 1, element)
                window.noty({
                    message: 'Type Element modifié avec succès',
                    type: 'success'
                })
            })
        },
        components: {
            AddUpdateElement,AddUpdateAttribut,Attributs
        },
        data() {
            return {
                elements: []
            }
        },
        created() {
            axios.get('/elements.fetch')
                .then(({data}) => this.elements = data);
        },
        methods: {
            createNewElement() {
                this.$emit('create_new_element')
            },
            createNewAttribut(elementId) {
                this.$emit('elementstep_create', elementId)
            },
            editElement(element) {
                this.$emit('edit_element', { element })
            },
            deleteElement(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/elements/${id}`)
                        .then(resp => {
                            this.elements.splice(key, 1)
                            window.noty({
                                message: 'Type Elément supprimé avec succès',
                                type: 'success'
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
