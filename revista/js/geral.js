/**
 * Função para validar campos do formulário das páginas.
 * Para campos que NAO deseja validar, adicionar o atributo:  alt="no_required"
 * 
 * 
 * <code>
 *    	// Exemplo: 
 *     	<form id="frmCadastro" onsubmit="return validar('frmCadastro');">
 * </code> 
 */


function formatNome(campo) 
{
	if(campo.value == 'Nome:') {
		campo.value = '';
	}
	else if(campo.value == ''){
		campo.value = 'Nome:';
	}
}

function formatEmail(campo) 
{
	if(campo.value == 'E-mail:') {
		campo.value = '';
	}
	else if(campo.value == ''){
		campo.value = 'E-mail:';
	}
}



/** 
 * Função Máscara de Entrada. Modo de usar: 
 *
 * Evento onkeypress:	onkeypress="return mascara(this,'(99) 9999-9999',event);"
 * 		CEP  -> 99999-999 							CPF  -> 999.999.999-99
 * 		CNPJ -> 99.999.999/9999-99 					Data -> 99/99/9999
 * 		TEL  -> (99) 999-9999 						C/C  -> 999999-!
 * 
 * 
 * Evento onkeypress:	onkeypress="return mascara(this,'num',event);"
 * 		Somente Números				-> 'num'	
 * 		Somente Números com Ponto	-> 'num_ponto'	
 * 		Somente Números	com Vírgula	-> 'num_virgula'	
 * 
 * 
 * Evento onkeyup:	onkeyup="return mascara(this,'m_s',event);"
 * 		Texto em Minúsulo 	e sem acento -> m	
 * 		Texto em Maiúsculo 	e sem acento -> M
 * 		Texto em Minúsulo 	e sem acento 	e sem espaço -> m_s
 * 		Texto em Maiúsculo 	e sem acento e sem espaço -> M_S	
 * 
 * @access public 
 * @param object campo	:	Coloca-se o 'this' para poder pegar o campo input.
 * @param string mask	:	Formato da máscara de entrada desejada.
 * @param string event	:	Coloca-se 'event' para que possa funcionar tanto no IE quanto no Firefox.
 * @return void 
 */ 

function mascara(campo,mask,event) 
{		

	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;


	if((mask == "num") || (mask == "num_ponto") || (mask == "num_virgula"))
	{
		
		// Somente numeros aceitos
		if(mask == "num")
		{
			if((keyCode > 47) && (keyCode < 58)) {
				return true;
			}
			else{
				keyCode=0;
				return false;
			}
		}

		// Somente numeros e ponto aceitos
		if(mask == "num_ponto")
		{
			if((keyCode > 45) && (keyCode < 58)) {
				return true;
			}
			else{
				keyCode=0;
				return false;
			}
		}

		// Somente numeros e virgula aceitos
		if(mask == "num_virgula")
		{
			if(((keyCode > 47) && (keyCode < 58)) || (keyCode == 44)) {
				return true;
			}
			else{
				keyCode=0;
				return false;
			}
		}
		
	}
	
	
	
	var i, count, valor, campoLen, maskLen, bolMask, cod;
		
	valor = campo.value;
	
	if(mask == "m" || mask == "M" || mask == 'M_S' || mask == 'm_s')
	{
		valor=valor.toLowerCase()// transforma todas as letras em minusculas para fazer as substituicoes de acentuacao
		valor=valor.replace(/[áàãâä]/g,'a')
		valor=valor.replace(/[éèêë&]/g,'e')
		valor=valor.replace(/[íìîï]/g,'i')
		valor=valor.replace(/[óòõôö]/g,'o')
		valor=valor.replace(/[úùûü]/g,'u')
		valor=valor.replace(/[ç]/g,'c')
		
		 // retira o espaço da string
		if(mask == 'M_S' || mask == 'm_s')   valor=valor.replace(/[ ]/g,''); 
		else valor=valor.replace(/[ ]/g,' ');
		
		
		for(var i=0;i<valor.length;i++){
			if(' @.-,_/:0123456789abcdefghijklmnopqrstuvwxyz'.indexOf(valor.charAt(i))==-1)valor=valor.replace(valor.charAt(i),' ')
		}
		
		if(mask == 'M' || mask == 'M_S') { valor=valor.toUpperCase() } // se a opc escolhida for 'M', entao transforma todas as letras em maiuscula
		if(mask == 'm' || mask == 'm_s') { valor=valor.toLowerCase() } // se a opc escolhida for 'm', entao transforma todas as letras em minusculas
	
		return (campo.value = valor);
	}
	else
	{
		for(var i=0;i<valor.length;i++){
			if('.-,_/:0123456789'.indexOf(valor.charAt(i))==-1)valor=valor.replace(valor.charAt(i),' ')
		}

		// Limpa todos os caracteres de formatação que já estiverem no campo.
		valor = valor.toString().replace( "-", "" );
		valor = valor.toString().replace( "-", "" );
		valor = valor.toString().replace( ":", "" );
		valor = valor.toString().replace( ".", "" );
		valor = valor.toString().replace( ".", "" );
		valor = valor.toString().replace( "/", "" );
		valor = valor.toString().replace( "/", "" );
		valor = valor.toString().replace( "(", "" );
		valor = valor.toString().replace( "(", "" );
		valor = valor.toString().replace( ")", "" );
		valor = valor.toString().replace( ")", "" );
		valor = valor.toString().replace( " ", "" );
		valor = valor.toString().replace( " ", "" );
		valor = valor.toString().replace( "-", "" );
		valor = valor.toString().replace( "-", "" );
		valor = valor.toString().replace( ":", "" );
		valor = valor.toString().replace( ".", "" );
		valor = valor.toString().replace( ".", "" );
		valor = valor.toString().replace( "/", "" );
		valor = valor.toString().replace( "/", "" );
		valor = valor.toString().replace( "(", "" );
		valor = valor.toString().replace( "(", "" );
		valor = valor.toString().replace( ")", "" );
		valor = valor.toString().replace( ")", "" );
		valor = valor.toString().replace( " ", "" );
		valor = valor.toString().replace( " ", "" );
		campoLen = valor.length;
		maskLen = mask.length;
		
		i = 0;
		count = 0;
		cod = "";
		maskLen = campoLen;
		
		while (i <= maskLen) {
			bolMask = ((mask.charAt(i) == "-") || (mask.charAt(i) == ":") || (mask.charAt(i) == ".") || (mask.charAt(i) == "/"))
			bolMask = bolMask || ((mask.charAt(i) == "(") || (mask.charAt(i) == ")") || (mask.charAt(i) == " "))
			
			if (bolMask) {
				cod += mask.charAt(i);
				maskLen++; }
			else {
				cod += valor.charAt(count);
				count++;
			}
			i++;
		}
		campo.value = cod;
		
		if (keyCode != 8) {  	// backspace
			if (mask.charAt(i-1) == "9"){	// apenas números...
				return ((keyCode > 47) && (keyCode < 58));	// números de 0 a 9
			} 
			else { return true; } // qualquer caracter...
		}
		else { return true; }
	}
}


/** 
 * Função para validar campos do formulário.
 * 
 * @access public 
 * @param object item	:	Coloca-se o ID do form do formulário
 * @return void 
 */ 

function validar(item) 
{
	var frm = document.getElementById(item);	
	
	for (i=0; i < frm.elements.length; i++)
	{			
		// Validando campos do formulário
		if(frm.elements[i].type == "text" || frm.elements[i].type == "password" || frm.elements[i].type == "textarea" || frm.elements[i].type == "select-one")
		{
			if(frm.elements[i].alt != "no_required"  && frm.elements[i].disabled == false && frm.elements[i].readonly != false)
			{
					// Limpando o atributo CSS de estilo do campo do form
					frm.elements[i].className = "";
		
					// Validando campos de TEXT do formulário
					if (frm.elements[i].value == ""){
							Erro(frm.elements[i],'');
							return false;
					}
					// Validando campos de TEXT do formulário
					if ((frm.elements[i].type == "select-one") && (frm.elements[i].value == 0)){
							Erro(frm.elements[i],'Você não selecionou uma opção\n');
							return false;
					}
		
					// Validar email(verificao de endereco eletrônico)
					if (frm.elements[i].name == "email") {
							if (!(/^\w+([\_.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(frm.elements[i].value))){ 
									Erro(frm.elements[i], frm.elements[i].name.toUpperCase() + ' inválido!\nDigite novamente\n');
									return false;
							} 
					}	
					
					// Validar o numero de telefone
					if (frm.elements[i].name == "telefone"  || frm.elements[i].name == "telefone2" || frm.elements[i].name == "celular") {
						if (frm.elements[i].value.length < 14) {
								Erro(frm.elements[i], frm.elements[i].name.toUpperCase() + ' inválido!\nDigite novamente\n');
								return false;
						}
					}	
					
					// Validar o CEP
					if (frm.elements[i].name == "cep") {
						if (frm.elements[i].value.length < 9) {
								Erro(frm.elements[i], frm.elements[i].name.toUpperCase() + ' inválido!\nDigite novamente\n');
								return false;
						}
					}					
			}
		}
	} // fim do FOR
	return true;
}


function Erro( form, msg )
{
		// Inserindo valor inicial na variável de erro	
		erro  = "Preencha o campo: "+ form.name.toUpperCase() +"\n";
		if(msg != "") { erro = msg; }
		
		// Mudando o atriburto de CSS para dar destaque
		form.className = "error_form";
		
		// Limpando o valor errado e setando como focus
		if(form.type == "text" || form.type == "password" || form.type == "textarea" ) {
			if(form.type != "textarea"){
				form.value = "";
			}
		}
		// Exibindo o erro
		alert(erro);
		form.focus();
		return false;
}

//=====================================================================================================================
/*	----------------------------------------------------------------------------------------------------------
	AUTOR...:	Diego Eyer <diego@friwebdesign.com>
	----------------------------------------------------------------------------------------------------------

	FUNÇÃO..:	Camadas(numLayer, totalCamadas)
	DESC....:	Função para trabalhar com camdas.
*/
//=====================================================================================================================
	
	function camada(numLayer, totalCamadas)
	{
		for(var i = 1; i <= totalCamadas; i++)
		{ 
			document.getElementById('fase' + i).style.display 	= 'none';
		}
		document.getElementById('fase' + numLayer).style.display  	= '';
	}
		
	function ocultar(item)
	{
		if (document.getElementById(item).style.display  == '')
		{
			document.getElementById(item).style.display  = 'none';
		}
	}