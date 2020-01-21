<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'CaptureTransactionByQr',
        [
            'transactionId' => $config->get('transactionId'),
        ],
        null,
        [
            'Qr' => [
                'contents' => 'iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAMAAACahl6sAAADAFBMVEX///////////////////////' .
                '/////////////////////////////////////////////////////////////////////////////////////////ica' .
                'vVPoztlL3KysoPDw9iYmKwsLD+6fbQEHHIAFvGAFnfRZPwlbndOYL///zypMzOBGb/6eXaY6zqXqbnc57HAF2urq4GBg' .
                'bm5uaRkZGMjIz+/v/WQIrIAFjZP4zedrfNBm/+3/bvyNnbfaLeTaDMAmfWR5jVUKHhgr3bZq7VPIvtlr7HAFbFAFTxu9' .
                'bLy8sBAQH29va9vb1GRkbqfbzZQIzed7jLAGDqn8X///3/+fX58fbRH3fNBWnodaTpgKXvob/cbrPLAWT81uf//P/wos' .
                'TriKf64uv7+/tDQ0NmZmbt7e32y+bKAWLZOorfebbJAGDeTJbzrtPOCmz/9vredLPHAFvYK3z5y+JHR0fr6+tNTU2YmJ' .
                'jfVZXPDGvmW6PVK3vKAGPNCXDiTpvmWKDUJIPLAGXNA2jkTJjmVZ7mU53mV6DVKnnMBGfXPYrlVJr51Obx8fGTk5NoaG' .
                'hpaWn4+PiysrIrKyvz8/P41e7NCG/HAFjMAGTLAGLIAF7FAFXxvNb6+vqZmZn0oMzNBGTKAGKxsbHV1dX0nsrOA2XJAF' .
                '9aWlovLy/n5+f0st3ULoXJAFvKAGHMAGbJAF7u7u7/8vjumb7VMnvKA2LIAFzKAGDLAGPLAGTMAGXJAF3yv9jk5OQiIi' .
                'Kpqan/+/ntv9DpgKzYS47PHHDRDmvRB2vKAGTIAGPFAFvxvNdRUVHIyMj99ff93uP9yePprc/lmMvmmszllcn55fLc3N' .
                'z5+fmJiYkQEBBQUFDg4ODi4uIHBwc0NDTj4+N1dXUaGhoLCwttbW2dnZ2tra3Dw8Pf39/e3t7h4eG6uroEBAQ1NTXp6e' .
                'mcnJxFRUUZGRkJCQkICAgKCgoCAgIxMTHo6Oi8vLyioqJ0dHRPT082NjYyMjIzMzM4ODhlZWUAAAD///+AnJ14AAAAHH' .
                'RSTlPj8Y10ZAQA9eXfbDz9sTqzDtdqbjLHElqt7Qrbutw4cQAAB0RJREFUeJztmn181VMcx0sKyWPkOSLPIo/FNE+FVJ' .
                '7yMIUoiUlWoiwyFEvJQx7mRhpaMtu02O5GsZSnVNLUWC1GK6mspCzr9/W793d37z33fL/nd267v+13e32//2znnO/5fD' .
                '/vc/d7uOesCewi0aSxDcQqGMRt4Qcx7CKYFJwXaglJgCTUtcRsogoip+WOQRiEQbRBAA/bMURUNiT6lFXEMVFOzx2DME' .
                'iDgCCmCHUEhCiBGBLF5RZShUhgEAZhkNiDEPaoUCHbWadKMQiDMEhDgFBFtYiiM0stCYMwSKODUD4IV0SoMm3ZVSAqdw' .
                'zCIAyiC2JnDfER3Vi9BGwXjkEYhEE0QLQCmYwkiK6IyeI4ka1tzAoGIRIIHwyiHSoQpKptiwh5Sqhb+CXKzNAYgzAIg0' .
                'QDIlYWhcUsyroiU5yCtIgFojLFLgZhEAbRBSFMEWZFURWIzpCSBhljEAZpDBBVlkqdQLazTdUklIiu0GQGYRAG0QUR+6' .
                'OzR7VwBtUCITaU8AzCIAwSNYg4j0hXWSfSVaYIWqKmcgEYhEGcBEH0COsEDWFd9IBYp1wpVokqzCAMwiAaIEiqrID4IF' .
                'wJ9iOKIljESqgWALEXS5AmTZWxW7PdmzdvIYRLQfZAJoix514t944DkKa2IGa02mffeADZUfvfdjRq/t229Z8tlsh++z' .
                'sFQtkmsORaVpggfxubN1XL8Ve1P2HjhvV/+uYdcGAARK5C3bVUY06ArPtj7ZoqOVZX/f5b5a+1vxjGqoqVvpmt3Q6yov' .
                'xnQscXP1WWbTaWL/sxSOJmkNKwuUt/WOKP7xcvWrTwO3/Xgm8NY8PKOhJHQOSJCA2iHuqSQL75+isrvpw/f94Xc0s+/8' .
                'zsnDPbWPGp+fOgcBAqiMLiuPMgnxQXBcLr9RYWfPzRrPyZ5h9YjbHuQ4CD28QRSF6uEEU5H2S/DzDjPWO6OdosfkHMyJ' .
                'r2LsA7y423zcd8m3gGyc2c+hbAFKPmTYBDYg5iqyD2iAqhKRLIG5MLinJzCz0eT5aJ8LonL8NsvfbqK/DyJOMlgENbaJ' .
                'klkiJsOAHy4tYXnp/4nNkzYfyz4zIL0595euyYp570PpH2+OiMxx4dlfoIwEhjBMBhh7sb5OGHfGPbrY9m+IPDhpo/Uh' .
                '7wZg0BuD9v8H2QfO89MKN64yBo1dLNIFVwt5U18C4Y0P/OO/rdfhvc2rfPLTlJN9904w29B18P102+FuAa42rzvuVmkD' .
                'W9lltZPXvAVd2vvAIu7wZdL7v0Es/FcFFilws9CXDB+Z07wXnGuQBHxBoE6Rf15BJYpvWudc7ZgdyzzLvWmR3hjNPNoQ' .
                '6n9T71lJNPghNPMEGOb38cHGu0g7BvYog4tlThNSPGYw6yptcxgU/kaN8n0haO6gZHds7OSB0AM1Og/+QEyO6esQgW9K' .
                'yFsG9iLgSpgnZWqu8a6Zvvv0byO/YZndxpaeLwlMSCBPOKKekCVeXbXQ5SClsG+romWXethbP8dy1I6gpziwcvhqShVm' .
                '5p+YqGA9HTC2XXPUd6Ve6Yvsz3gjshbe68TPPJkTZqfGry+HHenPRR7c1W2tjEAAhSgDBLWHEWJBjmk91rPdnzcnOyfA' .
                '/5vAyzNcy8Rqw/LXeDLKjwx1r8XcuMwtR+gYvd3SAjrdY2GmReB9jqv/26G6TSalWQIAXZdQ9ER0D0J8ogVuiCDCsRXl' .
                'EQJaJLNdYIIN6pw4WXxrgFKR4jvsbHK0hh6gTxi1UMQUTrSMhJiLDexV7oyY/4qisvHlIYSWhckKxpXTtFbD7EIUhRTn' .
                'H6EGk7yLUg60MgERt0mUltrQ26geEbdK4FmRIEEbdMk0sWmxi+LdNaYcvUCRAgWkEVFU3dXat05BQzJvYI28ReEtrEnm' .
                '4YIwZBYBM7qIKIi1WQTIdBVMcKq+eUbTZWhR0ruBdEedBTs8kwVlX4z99at3A5iProbXZZpXj05l4Q+jC0bNmcHoOsvI' .
                'jD0BiCUBMVehhyPY6nxQrIctlixRKkHv8w4C6QevwLh7tA5FCpKMbqB0L4VAWRrrJOmBWVkExERQwGYRAG0QUh1FVhW0' .
                'vlkXCmmKssxSAMwiDRgFAWkAQhKAE5kzBE2VOwR9RjEAZxHITIUo2JPghQap6cRKyg7ZoxCIMwyM6BEOqUK4UFRI6qIH' .
                'QhY0TRUBKDMAiD6ILIZUQ9VQJSSxyTBaiaqnUhVBiEQRoGROxXtWT1CG6iliLJVkCVySAMwiBRg4j2qHoiCJFFqBCGKB' .
                'BiLqLEIAzCIBogWkH4tMVCLMhytuuCJIhjDMIgToIgCvp6slEtx0hLzEQEGIRBGCQWIICHqIe0CFC5MlGAsmi7AAzCIA' .
                'yy8yC2eraOiMqIpgxI2NBbMwZhEHeAUDJEi5hrN6YqRWExCIMwiDMghhxaZqMsparCIAzCIDsPgkSU6ioVwTFVRdbUm8' .
                'cgDOI4iCoUhqgbgR27rbho3XbhGIRBGEQDZFcIBnFbMIjb4n++V9eqMLoQXAAAAABJRU5ErkJggg==',
            ],
        ])
    ->run()
;

print_response($response);
