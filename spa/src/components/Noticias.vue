<template>
  <div class="container">
    <h1 class="display-3">Cadastro de Notícias</h1>
    <div class="row">
      <div class="col-md-5">
        <form action>
            <div class="form-group">
                <label for="Título">Título</label>
                <input type="text" class="form-control" id="titulo" v-model="Noticia.titulo" />
            </div>
            <div class="form-group">
                <label for="Conteúdo">Conteúdo</label>
                <textarea class="form-control" id="conteudo" v-model="Noticia.conteudo" />
            </div>
            <div class="form-group">
                <label for="categorias">Categorias</label>
                <select name="" id="" class="form-control" v-model="Noticia.categoria_id">
                    <option value="">Selecione</option>
                    <option value="categorias.id" v-for="categoria in Categorias.dados" 
                        :selected="Noticia.categoria_id == categoria.id"> {{ categoria.nome }} </option>
                </select>
            </div>
        </form>
      </div>
      <div class="col-md-7">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>Cód</th>
              <th>Título</th>
              <th>Categoria</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="noticia in Noticias.dados">
              <td>{{ noticia.id }}</td>
              <td><a href="javascript:void(0);" @click="carregarNoticia(noticia)"> {{ noticia.titulo }} </a></td>
              <td>{{ noticia.categoria.nome }}</td>
              <td>
                  <a href="javascript:void(0);" class="text-danger"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
    import Vue from 'vue'
    import VueResource from 'vue-resource'

    Vue.use(VueResource);

    export default {
        name: "Noticias",
        data(){
            return{
                Noticias: [],
                Noticia: {
                    id: "",
                    titulo: "",
                    conteudo: "",
                    categoria_id: "",
                    categorias: {}
                },
                Categorias: [],
            }
        },
        created(){
            this.listarNoticias();
            this.listarCategorias();
        },
        methods: {
            listarNoticias(){
                this.$http.get('http://localhost:8080/noticias?expand=categoria').then(response => {
                    this.Noticias = response.body;
                });
            },
            listarCategorias(){
                this.$http.get('http://localhost:8080/categorias').then(response => {
                    this.Categorias = response.body;
                });
            },
            carregarNoticia(){
                this.Noticia.id = Noticia.id;
                this.Noticia.titulo = Noticia.titulo;
                this.Noticia.conteudo = Noticia.conteudo;
                this.Noticia.categoria_id = Noticia.categoria_id;
                this.Noticia.categorias = Noticias.categorias;
            }
        }
    };
</script>

<style scoped>
</style>

