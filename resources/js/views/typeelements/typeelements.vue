<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Type Elements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Type Elements</li>
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
                            <span class="help-inline pr-1"> Liste des Types Elements </span>
                            <button class="btn btn-xs btn-primary" @click="createNewTypeElement()">Nouveau</button>
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
                        <div id="typeelementlist">

                            <div class="card card-widget" v-for="(typeelement, index) in typeelements" v-if="typeelements">
                                <div class="card-header">
                                    <div class="user-block">
                                        <span class="text-purple" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-typeelements-'+index">
                                            {{ typeelement.nom }}
                                        </span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editTypeElement(typeelement)">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-typeelements-'+index"><i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" @click="deleteTypeElement(typeelement.uuid, index)"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div :id="'collapse-typeelements-'+index" class="panel-collapse collapse in">
                                    <div class="card-body" >

                                        <div class="row">
                                            <div class="col-md-12 col-sm-6 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <dt>Description</dt>
                                                        <dd>{{ typeelement.description }}</dd>
                                                        <dt>Date Création</dt>
                                                        <dd>{{ typeelement.created_at | formatDate}}</dd>
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
                                                            <button class="btn btn-sm btn-success" @click="createNewAttribut(typeelement.id)">Nouvel</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <Attributs :typeelementId="typeelement.id" :attributs_prop="typeelement.attributs"></Attributs>
                                                        </div>

                                                    </div>
                                                    <!-- /.card-body -->

                                                </div>

                                            </div>
                                            <!-- /.col -->

                                        </div>

                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-md-12 col-sm-6 col-12">

                                                <div class="card card-default">
                                                    <div class="card-header">
                                                        <div class="form-inline float-left">
                                                            <span class="help-inline pr-1"> Sous-Type(s) </span>
                                                            <button class="btn btn-sm btn-info" @click="createNewSubtypeElement(typeelement.id)">Nouveau</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <SubtypeElements :typeelementId="typeelement.id" :subtypeelements_prop="typeelement.subtypes"></SubtypeElements>
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

        <AddUpdateTypeElement></AddUpdateTypeElement>
        <AddUpdateAttribut></AddUpdateAttribut>
        <AddUpdateSubtypeElement></AddUpdateSubtypeElement>
    </div>
</template>

<script>
    import AddUpdateTypeElement from './addupdate'
    import AddUpdateAttribut from './../attributs/addupdate'
    import Attributs from './../attributs/attributs'
    import AddUpdateSubtypeElement from './../subtypeelements/addupdate'
    import SubtypeElements from './../subtypeelements/subtypeelements'

    export default {
        name: "typeelements",
        mounted() {
            this.$on('typeelement_created', (typeelement) => {
                // insert le nouveau type element dans le tableau des types element
                this.typeelements.push(typeelement)
                window.noty({
                    message: 'Type Element créé avec succès',
                    type: 'success'
                })
            })
            this.$on('typeelement_updated', (typeelement) => {
                // on récupère l'index du type d element modifié
                let typeelementIndex = this.typeelements.findIndex(c => {
                    return typeelement.id === c.id
                })
                this.typeelements.splice(typeelementIndex, 1, typeelement)
                window.noty({
                    message: 'Type Element modifié avec succès',
                    type: 'success'
                })
            })
        },
        components: {
            AddUpdateTypeElement,AddUpdateAttribut,Attributs,AddUpdateSubtypeElement,SubtypeElements
        },
        data() {
            return {
                typeelements: []
            }
        },
        created() {
            axios.get('/typeelements.fetch')
                .then(({data}) => this.typeelements = data);
        },
        methods: {
            createNewTypeElement() {
                this.$emit('create_typeelement')
            },
            createNewAttribut(typeelementId) {
                this.$emit('create_attribut', typeelementId)
            },
            createNewSubtypeElement(typeelementId) {
                this.$emit('create_subtypeelement', typeelementId)
            },
            editTypeElement(typeelement) {
                this.$emit('edit_typeelement', { typeelement })
            },
            deleteTypeElement(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/typeelements/${id}`)
                        .then(resp => {
                            this.typeelements.splice(key, 1)
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
