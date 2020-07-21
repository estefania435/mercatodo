

const apiproduct = new Vue({
    el: '#apiproduct',
    data: {
        name: '',
        slug: '',
        div_messageslug: 'Slug exist',
        div_class_slug: 'badge badge-danger',
        div_appear: false,
        disable_button: 1
    },
    computed: {
        generateSlug : function () {
            var char = {
                "á":"a","é":"e","í":"i","ó":"o","ú":"u",
                "Á":"A","É":"E","Í":"I","Ó":"O","Ú":"U",
                "ñ":"n","Ñ":"N"," ":"-","_":"-"
            }
            var expr = /[áéíóúÁÉÍÓÚÑñ_ ]/g;
            this.slug = this.name.trim().replace(expr, function(e) {

                return char[e]
            }).toLowerCase()

            return this.slug;
        }
    },
    methods: {
        getProduct() {

            if (this.slug) {
                let url = '/api/product/' + this.slug;
                axios.get(url).then(response => {
                    this.div_messageslug = response.data;
                    if (this.div_messageslug === 'Slug available') {
                        this.div_class_slug = 'badge badge-success';
                        this.disable_button = 0;
                    } else {
                        this.div_class_slug = 'badge badge-danger';
                        this.disable_button = 1;
                    }
                    this.div_appear = true;

                    if (data.dat.name){
                        if(data.dat.name===this.name){
                            this.disable_button = 0;
                            this.div_messageslug = '';
                            this.div_class_slug = '';
                            this.div_appear = false;
                        }
                    }
                })
            }else {
                this.div_class_slug = 'badge badge-danger';
                this.div_messageslug = "you must write a product";
                this.disable_button = 1;
                this.div_appear = true;
            }
        }
    },
    mounted(){
        if (data.edit=='Si'){
            this.name = data.dat.name;
            this.disable_button = 0;
        }
        console.log(data);
    }

});
