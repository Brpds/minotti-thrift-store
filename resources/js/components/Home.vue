<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <div class="row">
                                <navCard-component card-name="Fornecedores" route-name="/fornecedores">

                                </navCard-component>
                                <navCard-component card-name="Usuários" route-name="/usuarios" implemented="no">

                                </navCard-component>
                                <navCard-component card-name="Produtos" route-name="/produtos">

                                </navCard-component>
                                <navCard-component card-name="Marcas" route-name="/marcas">

                                </navCard-component>
                                <navCard-component card-name="Relatórios" route-name="/relatorios" implemented="no">
                                
                                </navCard-component>

                                <navCard-component card-name="Avaliações" route-name="/avaliacoes" implemented="no">
                                    
                                </navCard-component>
                                <navCard-component card-name="Categorias" route-name="/categorias">
                                    
                                </navCard-component>
                                <navCard-component card-name="Adicionar" route-name="/adicionar" implemented="no">
                                    
                                </navCard-component>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        
</template>

<script>
export default {

}
</script>

<style>

</style>