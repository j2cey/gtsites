<template>
    <div class="col">

        <draggable tag="ul" :list="attributs"
                   :disabled="!enabled"
                   @change="orderChanged"
                   @start="dragging = true"
                   @end="dragging = false"
                   class="list-group todo-list" handle=".handle" data-widget="todo-list"
        >
            <li
                class="list-group-item"
                v-for="(element, idx) in attributs"
                :key="element.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <span class="text text-success" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-attribut-'+element.id">{{ element.nom }}</span>
                <!-- Emphasis label -->
                <ValueTypeDisplay :valuetype_prop="element.valuetype"></ValueTypeDisplay>


                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-pencil-square-o" @click="editAttribut(element)"></i>
                    <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#typeelementlist" :href="'#collapse-attribut-'+element.id">
                        <i class="fas fa-minus"></i>
                    </button>
                    <i class="fa fa-trash-o"></i>
                </div>

                <!-- Détail(s) de l'Attribut -->
                <div :id="'collapse-attribut-'+element.id" class="panel-collapse collapse in">
                    <div class="card-header">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <dl class="row">
                            <dt class="col-sm-4 h6">Type</dt>
                            <dd class="col-sm-8">
                                <ValueTypeDisplay :valuetype_prop="element.valuetype"></ValueTypeDisplay>
                            </dd>

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

                            <dt class="col-sm-4 h6">Participe au Libellé ?</dt>
                            <dd class="col-sm-8">
                                <small>
                                    <span class="text-lighter hidden-sm-down">
                                        <span v-if="element.est_libelle" class="badge badge-pill badge-success">oui</span>
                                        <span v-else class="badge badge-pill badge-danger">non</span>
                                    </span>
                                </small>
                            </dd>

                        </dl>
                    </div>

                </div>
                <!-- / Détail(s) de l'Attribut -->

            </li>
        </draggable>
    </div>
</template>

<script>
    import AttributBus from './attributBus'
    import ValueTypeDisplay from './../valuetypes/display'

    let id = 3;
    import draggable from 'vuedraggable'
    export default {
        props: {
            typeelementId: "",
            attributs_prop: {}
        },
        name: "attributs",
        display: "Handle",
        instruction: "Drag using the handle icon",
        order: 5,
        components: {
            draggable, ValueTypeDisplay
        },
        mounted() {
            AttributBus.$on('attribut_created', (add_data) => {
                if (this.typeelementId === add_data.typeelementId) {
                    this.createAttribut(add_data.attribut)
                }
            })

            AttributBus.$on('attribut_updated', (upd_data) => {
                // Attribut modifiée à mettre à jour sur la liste
                //console.log('elementattribut_to_update received at attributs', upd_data)
                if (this.typeelementId === upd_data.typeelementId) {
                    this.updateAttribut(upd_data.attribut)
                }
            })
        },
        data() {
            return {
                attributs: this.attributs_prop,
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
            editAttribut(attribut) {
                AttributBus.$emit('edit_attribut', attribut, this.typeelementId)
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
                    'valuetype': evt.moved.element.valuetype,
                    'ord': evt.moved.newIndex,
                    'oldIndex': evt.moved.oldIndex,
                    'newIndex': evt.moved.newIndex,
                });
                changeForm
                    .put(`/attributs/${evt.moved.element.uuid}`, fd)
                    .then(attributs => {
                        //console.log('orderChanged', elementattributs);
                        this.attributs = attributs;
                    }).catch(error => {
                    this.loading = false
                });
            },
            createAttribut(attribut) {
                let attributIndex = this.attributs.findIndex(c => {
                    return attribut.id === c.id
                })
                // si cet attribut n'existe pas déjà, on l'insère dans la liste
                if (attributIndex === -1) {
                    window.noty({
                        message: 'Attribut créé avec succès',
                        type: 'success'
                    })
                    this.attributs.push(attribut)
                }
            },
            updateAttribut(attribut) {
                // on récupère l'index de l'attribut modifié
                let attributIndex = this.attributs.findIndex(s => {
                    return attribut.id === s.id
                })
                this.attributs.splice(attributIndex, 1, attribut)
                window.noty({
                    message: 'Attribut modifié avec succès',
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
