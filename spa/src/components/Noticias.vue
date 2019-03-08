<template>
  <div class="container">
    <h1 class="display-3">Cadastro de Notícias</h1>
    <div class="row">
      <div class="col-md-5">
        <form action="">
            <input type="hidden" id="id" v-model="Noticia.id">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" v-model="Noticia.titulo" />
            </div>
            <div class="form-group">
                <label for="conteudo">Conteúdo</label>
                <textarea class="form-control" id="conteudo" v-model="Noticia.conteudo" />
            </div>
            <div class="form-group">
                <label for="categorias">Categorias</label>
                <select name="" id="categorias" class="form-control" v-model="Noticia.categoria_id">
                    <option value="">Selecione</option>
                    <option v-for="categoria in Categorias.dados" v-bind:value="categoria.id"
                        :selected="Noticia.categoria_id == categoria.id"> {{ categoria.nome }} </option>
                </select>
            </div>
            <hr>
            <div class="form-group">
                <button type="button" class="btn btn-warning float-left" @click="limparCampos">Limpar</button>
                <button type="button" class="btn btn-success float-right" @click="salvarNoticia(Noticia)">Salvar</button>
            </div>
        </form>
      </div>
      <div class="col-md-7">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
                <td colspan="2">
                    Mostrando de <strong>{{ ((Noticias.meta.currentPage -1) * Noticias.meta.perPage) +1 }}</strong>
                    até <strong> {{ Noticias.meta.currentPage * Noticias.meta.perPage }} </strong>
                    do total de <strong>{{ Noticias.meta.totalCount }}</strong>.<br>
                    Página <strong>{{ Noticias.meta.currentPage }}</strong> de <strong>{{ Noticias.meta.pageCount }}</strong>
                </td>
                <td colspan="2">
                    <label for="per-page">Mostar por página:</label>
                    <select name="" id="per-page" v-model="per_page" @change="listarNoticias(pagina, per_page)">
                        <option :value="10" :selected="per_page == 10">10</option>
                        <option :value="30" :selected="per_page == 30">30</option>
                        <option :value="50" :selected="per_page == 50">50</option>
                    </select>
                </td>
            </tr>
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
                  <a href="javascript:void(0);" class="text-danger" @click="excluirNoticia(noticia)"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
          <hr>
          <nav aria-label="Page navigation example">
              <ul class="pagination">
                  <li class="page-item" :class="{'disabled': Noticias.meta.currentPage == 1}">
                      <a class="page-link" href="javascript:void(0);" @click="listarNoticias(Noticias.meta.currentPage - 1, per_page)" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
                  <li class="page-item" v-for="i in Noticias.meta.pageCount" :class='{"active": Noticias.meta.currentPage == i}'>
                      <a class="page-link" href="javascript:void(0);" @click="listarNoticias(i, per_page)">{{ i }}</a>
                  </li>

                  <li class="page-item" :class="{'disabled': Noticias.meta.currentPage == Noticias.meta.pageCount}">
                      <a class="page-link" href="javascript:void(0);" @click="listarNoticias(Noticias.meta.currentPage + 1, per_page)" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
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
                pagina: 1,
                per_page: 5
            }
        },
        created(){
            this.listarNoticias(this.pagina, this.per_page);
            this.listarCategorias();
        },
        methods: {
            listarNoticias(pagina, per_page){

                let url = 'http://localhost:8080/noticias?expand=categoria';

                pagina = typeof pagina == "undefined" ? 1 : pagina;
                url += "&page" + pagina;
                this.pagina = pagina;

                pagina = typeof per_page == "undefined" ? 1 : per_page;
                url += "&per_page" + pagina;
                this.pagina = per_page;

                this.$http.get(url).then(response => {
                    this.Noticias = response.body;
                });
            },
            listarCategorias(){
                this.$http.get('http://localhost:8080/categorias').then(response => {
                    this.Categorias = response.body;
                });
            },
            carregarNoticia(Noticia){
                this.Noticia.id = Noticia.id;
                this.Noticia.titulo = Noticia.titulo;
                this.Noticia.conteudo = Noticia.conteudo;
                this.Noticia.categoria_id = Noticia.categoria_id;
                this.Noticia.categorias = Noticia.categorias;
            },
            salvarNoticia(Noticia){

                let data = {
                    titulo: Noticia.titulo,
                    conteudo: Noticia.conteudo,
                    categoria_id: Noticia.categoria_id
                };

                let prom = null;
                let msg = "";

                if(Noticia.id === ""){
                    prom = this.$http.post('http://localhost:8080/noticias', data);
                    msg = "Notícia cadastrada com Sucesso !";
                } else {
                    prom = this.$http.put('http://localhost:8080/noticias/' + Noticia.id, data);
                    msg = "Notícia alterada com Sucesso !";
                }

                prom.then( () => {
                    this.listarNoticias(this.pagina, this.per_page);
                    this.Noticia = {
                        id: "",
                        titulo: "",
                        conteudo: "",
                        categoria_id: "",
                        categorias: {}
                    };
                    alert(msg);
                });
            },
            limparCampos(){
                this.Noticia = {
                    id: "",
                    titulo: "",
                    conteudo: "",
                    categoria_id: "",
                    categorias: {}
                };
            },
            excluirNoticia(Noticia){
                if(confirm("Deseja excluir a notícia " + Noticia.titulo + "?")){
                    this.$http.delete('http://localhost:8080/noticias/' + Noticia.id).then(() => {
                       alert("Excluído com sucesso !");
                       this.listarNoticias(this.pagina, this.per_page);
                    });
                }
            }
        }
    };
</script>

<style scoped>
</style>

