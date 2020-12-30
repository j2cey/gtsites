<template>
    <div class="col">

        <draggable tag="ul" :list="subtypeelements"
                   :disabled="!enabled"
                   @change="orderChanged"
                   @start="dragging = true"
                   @end="dragging = false"
                   class="list-group todo-list" handle=".handle" data-widget="todo-list"
        >
            <li
                class="list-group-item"
                v-for="(element, idx) in subtypeelements"
                :key="element.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <span class="text text-info" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-subtypeelement-'+element.id">{{ element.nom }}</span>
                <!-- Emphasis label -->
                <small class="badge badge-pill badge-default"> {{ element.subtype.nom }}</small>


                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-pencil-square-o" @click="editSubtypeElement(element)"></i>
                    <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-subtypeelement-'+element.id">
                        <i class="fas fa-minus"></i>
                    </button>
                    <i class="fa fa-trash-o"></i>
                </div>

                <!-- Détail(s) de l'Attribut -->
                <div :id="'collapse-subtypeelement-'+element.id" class="panel-collapse collapse in">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <dl class="row">
                            <dt class="col-sm-4 h6">Type</dt>
                            <dd class="col-sm-8">{{ element.subtype.nom }}</dd>

                            <dt class="col-sm-4 h6">Obligatoire</dt>
                            <dd class="col-sm-8">
                                <small>
                                    <span class="text-lighter hidden-sm-down">
                                        <span v-if="element.obligatoire" class="badge badge-pill badge-danger">oui</span>
                                        <span v-else class="badge badge-pill badge-success">non</span>
                                    </span>
                                </small>
                            </dd>

                            <dt class="col-sm-4 h6">Description</dt>
                            <dd class="col-sm-8">{{ element.description }}</dd>

                        </dl>
                    </div>

                </div>
                <!-- / Détail(s) de l'Attribut -->

            </li>
        </draggable>
    </div>
</template>

<script>
    import SubtypeelementBus from './subtypeelementBus'
    let id = 3;
    import draggable from 'vuedraggable'
    export default {
        props: {
            typeelementId: "",
            subtypeelements_prop: {}
        },
        name: "subtypeelements",
        display: "Handle",
        instruction: "Drag using the handle icon",
        order: 5,
        components: {
            draggable
        },
        mounted() {
            SubtypeelementBus.$on('subtypeelement_created', (add_data) => {
                if (this.typeelementId === add_data.typeelementId) {
                    this.createSubtypeElement(add_data.subtypeelement)
                }
            })

            SubtypeelementBus.$on('subtypeelement_updated', (upd_data) => {
                // Sous-type modifié à mettre à jour sur la liste
                if (this.typeelementId === upd_data.typeelementId) {
                    this.updateSubtypeElement(upd_data.subtypeelement)
                }
            })
        },
        data() {
            return {
                subtypeelements: this.subtypeelements_prop,
                enabled: true, // TODO: Nettoyer composant (rétirer les lignes de codes inutiles)
                list: [
                    { name: "John", text: "", id: 0 },
                    { name: "Joao", text: "", id: 1 },
                    { name: "Jean", text: "", id: 2 }
                ],
                dragging: false
            };
        },
        computed: {
            draggingInfo() {
                console.log(this.dragging ? "under drag" : "");
            }
        },
        methods: {
            editSubtypeElement(subtypeelement) {
                SubtypeelementBus.$emit('edit_subtypeelement', subtypeelement, this.typeelementId)
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Juan " + id, id, text: "" });
            },
            orderChanged(evt) {
                //console.log('gonna change order',evt, evt.moved.element, evt.moved.oldIndex, evt.moved.newIndex,this.elementattributs);
                //console.log('lets change order:', this.elementattributs);
                const fd = undefined;
                let changeForm = new Form({
                    'nom': evt.moved.element.nom,
                    'description': evt.moved.element.description,
                    'type_element_id': evt.moved.element.type_element_id,
                    'subtype': evt.moved.element.subtype,
                    'ord': evt.moved.newIndex,
                    'oldIndex': evt.moved.oldIndex,
                    'newIndex': evt.moved.newIndex,
                });
                changeForm
                    .put(`/subtypeelements/${evt.moved.element.uuid}`, fd)
                    .then(subtypeelements => {
                        //console.log('orderChanged', elementattributs);
                        this.subtypeelements = subtypeelements;
                    }).catch(error => {
                    this.loading = false
                });
            },
            createSubtypeElement(subtypeelement) {
                let subtypeelementIndex = this.subtypeelements.findIndex(c => {
                    return subtypeelement.id === c.id
                })
                // si ce sous-type n'existe pas déjà, on l'insère dans la liste
                if (subtypeelementIndex === -1) {
                    window.noty({
                        message: 'Sous-Type créé avec succès',
                        type: 'success'
                    })
                    this.subtypeelements.push(subtypeelement)
                }
            },
            updateSubtypeElement(subtypeelement) {
                // on récupère l'index du sous-type modifié
                let subtypeelementIndex = this.subtypeelements.findIndex(s => {
                    return subtypeelement.id === s.id
                })
                this.subtypeelements.splice(subtypeelementIndex, 1, subtypeelement)
                window.noty({
                    message: 'Sous-Type modifié avec succès',
                    type: 'success'
                })
            }
        }
    };
</script>
<style scoped>
    .button {
        margin-top: 25px;
    }
    .handle {
        float: left;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .close {
        float: right;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    input {
        display: inline-block;
        width: 50%;
    }
    .text {
        margin: 10px;
    }
</style>
