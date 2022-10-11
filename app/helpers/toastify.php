<?php

function toastify(string $message, string $type, int $duration = 3000, string $gravity = 'bottom')
{

    if ($type === 'success') $color = '#83BD75';
    else if ($type === 'danger') $color = 'red';
    else if ($type === 'info') $color = 'blue';
    else if ($type === 'warning') $color = '#FBCB0A';


    if (!isset($_SESSION['toastify'])) {
        $_SESSION['toastify']['color'] = $color;
        $_SESSION['toastify']['message'] = $message;
        $_SESSION['toastify']['duration'] = $duration;
        $_SESSION['toastify']['gravity'] = $gravity;
    }
}


function getToastify()
{


    if (isset($_SESSION['toastify'])) {
        $color = $_SESSION['toastify']['color'];
        $message = $_SESSION['toastify']['message'];
        $duration = $_SESSION['toastify']['duration'];
        $gravity = $_SESSION['toastify']['gravity'];
        echo "<script>
                    Toastify({
                        text: '$message',
                        duration: $duration,
                        gravity: '$gravity',
                        style: {
                            background: '$color',
                            color: '#FFF'
                        },
                        offset: {
                            x: 20, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 20 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                        close: true
                    }).showToast();
            </script>";
        unset($_SESSION['toastify']);
    }
}
