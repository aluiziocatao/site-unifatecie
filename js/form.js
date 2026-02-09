document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formulario');
    const msg = document.getElementById('form-msg');
    const telefoneInput = document.getElementById('telefone');
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

    if (!form || !(form instanceof HTMLFormElement)) {
        return;
    }

    /* =========================
       MÁSCARA DE TELEFONE
    ========================== */
    function maskTelefone(value) {
        value = value.replace(/\D/g, '');

        if (value.length > 11) {
            value = value.slice(0, 11);
        }

        if (value.length > 10) {
            value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        } else if (value.length > 6) {
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
        } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
        } else {
            value = value.replace(/^(\d*)$/, '($1');
        }

        return value;
    }

    if (telefoneInput) {
        telefoneInput.addEventListener('input', function (e) {
            e.target.value = maskTelefone(e.target.value);
        });
    }

    /* =========================
       ENVIO DO FORMULÁRIO
    ========================== */
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        msg.innerHTML = '';
        submitBtn.disabled = true;
        submitBtn.innerText = 'Enviando...';

        const telefoneNumeros = telefoneInput.value.replace(/\D/g, '');

        if (telefoneNumeros.length < 10) {
            msg.innerHTML = '<span style="color:red">Digite um WhatsApp válido.</span>';
            submitBtn.disabled = false;
            submitBtn.innerText = 'Tenho Interesse';
            return;
        }

        const formData = new FormData(form);

        try {
            const response = await fetch('backend/enviar-formulario.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.text();

            if (result.trim() === 'OK') {
                msg.innerHTML = '<span style="color:green">Mensagem enviada com sucesso!</span>';
                form.reset();
            } else {
                msg.innerHTML = '<span style="color:red">Erro ao enviar. Tente novamente.</span>';
            }

        } catch (err) {
            msg.innerHTML = '<span style="color:red">Erro de conexão. Tente novamente.</span>';
        }

        submitBtn.disabled = false;
        submitBtn.innerText = 'Tenho Interesse';
    });

});
