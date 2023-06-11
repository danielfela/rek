<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

</head>
<body>
<div id="app">
    <v-app id="inspire">
        <v-data-table
                :headers="headers"
                :items="cars"
                :items-per-page="5"
                class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar
                        flat
                >

                    <v-dialog
                            v-model="dialog"
                            max-width="500px"
                    >

                        <v-card>
                            <v-card-title>
                                <span class="text-h5">Form</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col
                                                cols="12"
                                                sm="6"
                                                md="4"
                                        >
                                            <v-text-field
                                                    v-model="editedItem.registration"
                                                    label="Nr rejestracyjny"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                                cols="12"
                                                sm="6"
                                                md="4"
                                        >
                                            <v-text-field
                                                    v-model="editedItem.brand"
                                                    label="marka"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                                cols="12"
                                                sm="6"
                                                md="4"
                                        >
                                            <v-text-field
                                                    v-model="editedItem.model"
                                                    label="Model"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                        small
                        @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn
                        color="primary"
                        @click="initialize"
                >
                    Reset
                </v-btn>
            </template>
        </v-data-table>
    </v-app>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            dialog: false,
            dialogDelete: false,
            headers: [
                {
                    text: 'Lp.',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {text: 'Nr rejestracyjny', value: 'registration'},
                {text: 'Marka', value: 'brand'},
                {text: 'Model', value: 'model'},
                {text: 'Data utworzenia', value: 'created'},
                {text: 'Data modyfikacji', value: 'updated'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],
            cars: [],
            editedIndex: -1,
            editedItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
            defaultItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
            dialogDelete(val) {
                val || this.closeDelete()
            },
        },
        created: function () {
            this.fetchData();
        },

        methods: {
            initialize() {

            },

            editItem(item) {
                this.editedIndex = this.cars.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem(item) {
                this.editedIndex = this.cars.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            deleteItemConfirm() {
                this.cars.splice(this.editedIndex, 1)
                this.closeDelete()
            },

            close() {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            closeDelete() {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })

                const {id} = this.editedItem;
                fetch(`/index/delete/${id}`, {
                    method: 'POST',
                }).then(response => response.json())
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.cars[this.editedIndex], this.editedItem)
                } else {
                    this.cars.push(this.editedItem)
                }

                this.close()

                const formData = new FormData();
                const {id, brand, model, registration} = this.editedItem;
                formData.append('brand', brand);
                formData.append('model', brand);
                formData.append('registration', registration);

                fetch(`/index/update/${id}`, {
                    method: 'POST',
                    body: formData,
                }).then(response => response.json())
            },

            fetchData: function () {


                fetch(`/index/get`).then(response => response.json().then(res => this.cars = res))

                /*    var self = this;
                    var apiURL = '/api/cards';
                    axios.get( apiURL )
                        .then ( function( response ) {
                            data = response['data'];
                            // console.log(data);
                            self.itemslist = data;
                            console.log(self._data);
                        });*/
            }
        },
    })
</script>
