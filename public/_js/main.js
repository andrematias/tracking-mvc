//Tradução do datepicker para pt_br
jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Próximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'yy-mm-dd',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});

//Configurações gerais dos elementos da página
$(function(){
    //Remove a mensagem ao clicar
    $('[id=type_message]').click(function(){
        $(this).remove();
    });

    //Remove as mensagens apos 10 segundos
    setInterval(function(){
            $('[id=type_message]').remove();
    }, 10000);

    $("input[type='text']#datepicker1").datepicker({showAnim: 'slideDown'}); 
    $("input[type='text']#datepicker2").datepicker({showAnim: 'slideDown'}); 
});
