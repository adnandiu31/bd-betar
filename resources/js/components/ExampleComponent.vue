<template>
    <div class="row">
        <div class="col-sm-9 col-md-8 mx-auto">
            <div class="card shadow" style="border: 1px solid #cfcfcf">
                <div class="card-body">
                    <!-- form start -->
                    <form v-on:submit.prevent="submit" class="forms-sample data-create-form" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-md 6">
                                <label for="name" class="form-label">Name</label>
                                <input v-model="form.name"  class="form-control" type="text" name="name" id=""> 
                                <input v-model="form.id"  class="form-control" type="text" name="name" id="" hidden> 
                                <div v-if="searchData.length > 0">
                                    <ul class="border my-2 px-4 py-2 position-absolute bg-primary text-white" style="z-index:10;">
                                    <li v-for="(item,index) in searchData" :key="index"> <span @click="getSingleData(item.id)"> {{item.name}} </span> </li>
                                </ul>
                                </div>
                            </div>
                            <div class="col-md 6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input v-model="form.quantity" class="form-control" value="0" type="number" name="" id=""> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md 6">
                                <label for="name" class="form-label">Position</label>
                                <input v-model="form.position"  class="form-control" type="text" name="" id="" :disabled="form.position != null && form.position==singleData.position"> 
                            </div>
                            <div class="col-md 6">
                                <label for="quantity" class="form-label">Designation</label>
                                <input v-model="form.designation" class="form-control"  type="text" name="" id=""> 
                            </div>
                        </div>

                        <div class="py-4">
                            <button  type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </div>
                       
                    </form>    
                </div>
            </div>
        </div>
        <div class="col-md-3">
           <div class="card shadow" style="border: 1px solid #cfcfcf">
               <div class="card-body">
                   <p> {{ form.name}} </p>
                   <p>Previous quantity {{ this.singleData && singleData.quantity }} </p>
                   <p> {{form.quantity}} </p>
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
    data() {
        return {
            name: 'Create',
            searchData:[],
            filters: "",
            singleDataId:{},
            singleData:{},
            form: {
                name:  null,
                quantity:  null,
                position:  null,
                designation: null,
                id:null
            },
            
        }
    },
    mounted() {
        console.log('Component mounted.Yess')
    },
    watch: {
        "form.name": function (newVal, oldVal) {
            setTimeout(() => {
                this.getData()
            }, 500)
        },
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
            console.log(obj,'This is object values');
            return obj;
        },

        submit:function () {
            this.form = {...this.form};
            this.axios.post('/admin/parts/store',this.form).then((response) => {
                this.resetForm();
            })
        },

        resetForm() {
            var self = this; //you need this because *this* will refer to Object.keys below`

            //Iterate through each object field, key is name of the object field`
            Object.keys(this.form).forEach(function(key,index) {
            self.form[key] = '';
            });
        },

        getData: function () {
            console.log("I m in");
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

        getSingleData: function (id) {
            this.singleDataId = id;
            this.axios.get(`/admin/parts/single-data/${this.singleDataId}`).then((response) => {
                this.singleData = response.data;
                this.form.name = this.singleData.name;
                this.form.position = this.singleData.position;
                this.form.designation = this.singleData.designation;
                this.form.id = this.singleDataId;
                this.searchData = [];
                // console.log(this.singleData.name,'datas');
            })
        }
    }
}
</script>
