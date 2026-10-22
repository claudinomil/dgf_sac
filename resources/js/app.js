import './bootstrap';
import '@mdi/font/css/materialdesignicons.min.css'

// Component Javascript Tabela de Dados'''''''''''''''''''''''''''''''
// Import
import { montarTabela } from './components/tabela-dados';

// Disponibilizar para as telas que utilizam JavaScript tradicional.
window.montarTabela = montarTabela;
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
