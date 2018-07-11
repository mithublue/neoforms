var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'assets/';
elixir.config.publicPath = 'assets/';
elixir.config.css.outputFolder = './';

elixir(function(mix) {
    mix.less(['style.less'],'assets/css/style.css');
});