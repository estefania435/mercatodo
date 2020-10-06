const confirmdelete = new Vue({
    el: '#confirmdelete',
    data: {
        urltodelete: '',
    },

    methods: {
        you_want_to_delete(id) {
            this.urltodelete =document.getElementById('urlbase').innerHTML+'/'+id;
            $('#modal_delete').modal('show');
        }
    },


});
