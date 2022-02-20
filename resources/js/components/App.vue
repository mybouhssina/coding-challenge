<template>
    <div class="container">
        <h2>Trouver votre nom ninja</h2>
        <div v-show="!showResultsStep" class="search-step">
            <div class="content">
                <el-select
                    v-model="selectedWords"
                    multiple
                    :reserve-keywords="false"
                    clearable
                    filterable
                    remote
                    placeholder="Nom d'une technologie"
                    :remote-method="remoteMethod"
                    :multiple-limit="maxWords"
                    :loading="loading"
                >
                    <el-option
                        v-for="item in autocompleteResults"
                        :key="item"
                        :label="item"
                        :value="item"
                    >
                    </el-option>
                </el-select>
                <div class="search-button-container">
                    <el-button
                        @click="getName"
                        :disabled="!atLeastOneWordIsSelected"
                        :title="atLeastOneWordIsSelected ? '' : 'Veuillez selectionner au moins un mot'">
                        <font-awesome-icon icon="search" /> <span style="padding-left: 5px">Chercher</span>
                    </el-button>
                </div>
            </div>
            <div class="note">
                *Veuillez choisir entre 1 et {{maxWords}} mots
            </div>
        </div>
        <div v-show="showResultsStep" class="results-step">
            <div>
                Votre nom ninja: <strong>{{ninjaName}}</strong>
            </div>
            <div class="back-button-container">
                <el-button @click="showResultsStep = false">Faire une autre recherche</el-button>
            </div>
        </div>
    </div>
</template>

<script>
import { ElSelect, ElOption, ElButton } from 'element-plus'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import 'element-plus/dist/index.css'
import { ElMessageBox } from 'element-plus'

export default {
    components: { ElSelect, ElOption, FontAwesomeIcon, ElButton },
    name: "Ninjify",
    data: function() {
        return {
            selectedWords: null,
            loading: false,
            autocompleteResults: [],
            ninjaName: null,
            showResultsStep: false,
            maxWords: 10
        }
    },
    computed: {
        atLeastOneWordIsSelected() {
            return this.selectedWords && this.selectedWords.length > 0;
        }
    },
    methods: {
        remoteMethod(query) {
            if (query) {
                this.loading = true
                axios.get(this.$route('techs.search', {tech: query}))
                    .then(
                        resp => {
                            this.autocompleteResults = resp.data
                        }
                    )
                    .catch(this.afficherErreur)
                    .finally(this.loading = false);
            } else {
                this.autocompleteResults = []
            }
        },
        getName() {
            axios.get(this.$route('getName', {x: this.selectedWords.join(',')}))
                .then(
                    resp => {
                        this.ninjaName = resp.data.name
                        this.showResultsStep = true
                    }
                )
                .catch(this.afficherErreur)
                .finally(this.loading = false);
        },
        afficherErreur() {
            ElMessageBox.alert('Une erreur inconnue est survenue, veuillez réssayer.', 'Erreur', {
                confirmButtonText: 'Fermer',
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
    align-items: center;

    ::v-deep(.el-select.el-select--default) {
        width: 300px;
        @media (max-width: 600px) {
            & {
                width: 200px;
            }
        }
    }



    .search-step {
        .content {
            display: flex;
            gap: 5px;
            .search-button-container {
                text-align: right;
            }
        }
        .note {
            font-size: 0.8em;
        }

    }
    .results-step {
        display: flex;
        flex-direction: column;
        gap: 10px;

        div {
            text-align:center;
        }
    }
}
</style>
