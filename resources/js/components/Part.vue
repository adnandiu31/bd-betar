<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="row">
                <div class="col-sm-9 col-md-8 mx-auto">
                    <div class="card shadow" style="border: 1px solid #cfcfcf">
                        <div class="card-body">
                            <!-- form start -->
                            <form v-on:submit.prevent="submit" class="forms-sample data-create-form" enctype="multipart/form-data" autocomplete="off">
                                <div class="row mb-2">
                                    <div :class="[form.id == null ? 'col-md-6' : 'col-md-4']">
                                        <label for="name" class="form-label">Part Name</label>
                                        <input v-model="form.name" @keyup="getData()"  class="form-control" type="text" name="name" id="" :class="{'border-danger':errors.name}">
                                        <div v-if="errors.name" class="text-danger my-2"> {{errors.name[0]}} </div>

                                        <input v-model="form.id"  class="form-control" type="text" name="name" id="" hidden>

                                        <div v-if="searchData.length > 0" class="w-100 pr-5 position-absolute" style="z-index:10;">
                                            <ul class="border my-2 px-4 py-2 bg-white w-100 navbar-nav">
                                                <li v-for="(item,index) in searchData" :key="index" class="mb-2 border-bottom" style="cursor:pointer;" >
                                                    <span class="app-text-hover app-text-primary d-block" @click="getSingleData(item.id)"> {{item.name}} </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div :class="[form.id == null ? 'col-md-6' : 'col-md-4']">
                                        <label for="quantity" class="form-label">Quantity ss</label>
<!--                                        <input v-model="form.quantity"  class="form-control" value=0 type="number" name="quantity" id="" :disabled="form.id != null">-->
                                        <input v-model="form.quantity"  class="form-control" value=0 type="number" name="quantity" id="" :disabled=true>
                                    </div>
                                    <div class="col-md-4" :hidden="form.id == null">
                                        <label for="quantity" class="form-label">Add new Quantity</label>
                                        <input v-model="form.newquantity"  class="form-control" value="0" type="number" name="quantity" id="">
                                    </div>
                                </div>

                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md-6">
                                        <label class="form-label" for="instrument_id">Instrument:</label>
                                        <select v-model="form.instrument_id" class="form-control" name="instrument_id" id="instrument" >
                                            <option  v-for="(item,index) in instruments" :key="index"  :value="item.id"> {{item.name}} </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="part_type_id">Slect Part Type:</label>
                                        <select v-model="form.part_type_id" class="form-control" name="part_type_id" id="part_type_id">
                                            <option v-for="(item,index) in part_types" :key="index" :value="item.id"> {{item.name}} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md-6">
                                        <label class="form-label" for="manufacture_id">Manufacture:</label>
                                        <select v-model="form.manufacture_id" class="form-control" name="manufacture_id" id="manufacture_id">
                                            <option  v-for="(item,index) in manufactures" :key="index"  :value="item.id"> {{item.name}} </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="parts_no" class="form-label">Part No</label>
                                        <input v-model="form.parts_no" class="form-control" type="number" name="parts_no" id="">
                                    </div>
                                </div>

                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md 6">
                                        <label for="specification" class="form-label">Specification</label>
                                        <input v-model="form.specification"  class="form-control" type="text" name="specification" id="">
                                    </div>
                                    <div class="col-md 6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input v-model="form.designation" class="form-control"  type="text" name="designation" id="">
                                    </div>
                                </div>

                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md-9">
                                        <label for="ledger_information" class="form-label">Ledger Information</label>
                                        <input v-model="form.ledger_information"  class="form-control" type="text" name="ledger_information" id="">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="purchase_date" class="form-label">Date</label>
                                        <input v-model="form.purchase_date" class="form-control"  type="date" name="purchase_date" id="">
                                    </div>
                                </div>
                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md-6">
                                        <label for="parts_pos" class="form-label">Part Position</label>
                                        <input v-model="form.parts_pos"  class="form-control" type="text" name="parts_pos" id="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="in_use" class="form-label">Number in use</label>
                                        <input v-model="form.in_use"  class="form-control" type="number" name="in_use" id="">
                                    </div>
                                </div>
                                <div class="row mb-2" :hidden="form.id != null">
                                    <div class="col-md-6">
                                        <label for="present_stock" class="form-label">Present Stock</label>
                                        <input v-model="form.present_stock" class="form-control"  type="number" name="present_stock" id="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description" class="form-label">Descriptone</label>
                                        <input v-model="form.description"  class="form-control" type="text" name="description" id="">
                                    </div>
                                </div>
                                <div class="row mb-2" :hidden="form.id != null">

                                    <div class="col-md-12">
                                        <label for="comments" class="form-label">Comment</label>
                                        <input v-model="form.comments" class="form-control"  type="text" name="comments" id="">
                                    </div>
                                </div>
                                <div class="mb-2" :hidden="form.id != null">
                                    <label for="attache_file" class="form-label">Attach a file</label>
                                    <input class="form-control"  type="file" name="comment" id="" >
                                </div>

                                <button type="submit" class="btn customButton mr-2">Submit</button>
                                <button @click="cancelSubmit()" class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div v-if="singleData" class="col-md-4">
                <div class="card shadow" style="border: 1px solid #cfcfcf">
                    <div  class="card-body">
                        <p class="mb-0 font-weight-bolder app-text-primary">PartName:</p>
                        <p class="font-weight-light text-black-50">{{ form.name}}</p>
                        <hr class="my-2">

                        <p class="mb-0 font-weight-bolder app-text-primary">Previous quantity:</p>
                        <p class="font-weight-light text-black-50">{{ singleData && singleData.quantity }}</p>
                        <hr class="my-2">

                        <p class="mb-0 font-weight-bolder app-text-primary">New quantity:</p>
                        <p class="font-weight-light text-black-50">{{form.newquantity}}</p>
                        <hr class="my-2">

                        <p class="mb-0 font-weight-bolder app-text-primary">Instrument Name:</p>
                        <p class="font-weight-light text-black-50">{{ singleData.instrument.name }}</p>
                        <hr class="my-2">

                        <p class="mb-0 font-weight-bolder app-text-primary">Part Type:</p>
                        <p class="font-weight-light text-black-50">{{ singleData.part_type.name }}</p>
                        <hr class="my-2">

                        <p class="mb-0 font-weight-bolder app-text-primary">Manufacture Name:</p>
                        <p class="font-weight-light text-black-50">{{ singleData.manufacture.name }}</p>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Something from "./SomeThing.vue"
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

export default {
    components: {
        Something
    },

    props: ['instruments','part_types','manufactures'],

    data() {
        return {
            name: 'Create',
            searchData:[],
            filters: "",
            singleDataId:{},
            singleData:'',
            errors:{},
            form: {
                name:  null,
                id:null,
                instrument_id:  null,
                part_type_id:  null,
                description: null,
                specification:null,
                designation:null,
                parts_no:null,
                purchase_date:null,
                parts_pos:null,
                manufacture_id:null,
                quantity:0,
                newquantity:null,
                in_use:null,
                present_stock:null,
                comments:null,
                ledger_information:null,
                parts_attached_file:null,
            },
        }
    },

    methods: {
        getFilter: function() {
             let obj = {};
            Object.keys(this.filters).forEach((element) => {
                if (this.filters[element] != null) {
                Object.defineProperties(obj, {
                    [element]: {
                    value: this.filters[element],
                    enumerable: true,
                    configurable: true,
                    writable: true,
                    },
                });
                }
            });
            return obj;
        },

        submit:function () {
            this.form = {...this.form};
            this.axios.post('/admin/parts',this.form)
            .then((response) => {
                if(response.status == 200) {
                    // this.resetForm();
                    window.location = response.data.redirect;
                }
            }).catch((errors)=>{
                this.errors = errors.response.data.errors;
            })
        },

        resetForm() {
            var self = this;
            Object.keys(this.form).forEach(function(key,index) {
                self.form[key] = '';
            });
        },

        getData: function () {
            const title = { name: this.form.name };
            this.axios.post('/admin/parts/get-data',title).then((response) => {
                if( response.data.length > 0) {
                    this.searchData = response.data
                }else{
                    this.searchData = []
                }
            })
            .catch(error => {
                this.errorMessage = error.message;
                this.searchData = []
            });
        },

        cancelSubmit: function () {
            if(this.form.id != null) {
                location.reload();
            }else{
                window.location = '/admin/parts'
            }
        },

        getSingleData: function (id) {
            this.singleDataId = id;
            this.axios.get(`/admin/parts/single-data/${this.singleDataId}`).then((response) => {
                this.singleData = response.data;
                this.form.name = this.singleData.name;
                this.form.quantity = this.singleData.quantity;
                this.form.id = this.singleDataId;
                this.searchData = [];
            })
        },
    }
}
</script>
