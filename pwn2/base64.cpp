#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdint.h>

// B?ng mã base64
static const char base64_table[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

// Hàm mã hoá Base64
char *base64_encode(const unsigned char *data, size_t input_length) {
    char *encoded_data;
    size_t output_length;
    size_t i, j;

    output_length = 4 * ((input_length + 2) / 3);
    encoded_data = (char *)malloc(output_length + 1);
    if (encoded_data == NULL) return NULL;

    for (i = 0, j = 0; i < input_length;) {
        uint32_t octet_a = i < input_length ? data[i++] : 0;
        uint32_t octet_b = i < input_length ? data[i++] : 0;
        uint32_t octet_c = i < input_length ? data[i++] : 0;

        uint32_t triple = (octet_a << 0x10) + (octet_b << 0x08) + octet_c;

        encoded_data[j++] = base64_table[(triple >> 3 * 6) & 0x3F];
        encoded_data[j++] = base64_table[(triple >> 2 * 6) & 0x3F];
        encoded_data[j++] = base64_table[(triple >> 1 * 6) & 0x3F];
        encoded_data[j++] = base64_table[(triple >> 0 * 6) & 0x3F];
    }

    // Thêm ký t? "=" n?u c?n thi?t
    for (i = 0; i < (3 - input_length % 3) % 3; i++) {
        encoded_data[output_length - 1 - i] = '=';
    }

    encoded_data[output_length] = '\0';
    return encoded_data;
}

// Hàm gi?i mã Base64
unsigned char *base64_decode(const char *data, size_t input_length, size_t *output_length) {
    unsigned char *decoded_data;
    size_t i, j;
    int k;
    size_t padding;

    if (input_length % 4 != 0) return NULL;

    *output_length = input_length / 4 * 3;
    if (data[input_length - 1] == '=') (*output_length)--;
    if (data[input_length - 2] == '=') (*output_length)--;

    decoded_data = (unsigned char *)malloc(*output_length + 1);
    if (decoded_data == NULL) return NULL;

    for (i = 0, j = 0; i < input_length;) {
        uint32_t sextet_a = data[i] == '=' ? 0 & i++ : base64_table[(uint8_t)data[i++]];
        uint32_t sextet_b = data[i] == '=' ? 0 & i++ : base64_table[(uint8_t)data[i++]];
        uint32_t sextet_c = data[i] == '=' ? 0 & i++ : base64_table[(uint8_t)data[i++]];
        uint32_t sextet_d = data[i] == '=' ? 0 & i++ : base64_table[(uint8_t)data[i++]];

        uint32_t triple = (sextet_a << 3 * 6)
                        + (sextet_b << 2 * 6)
                        + (sextet_c << 1 * 6)
                        + (sextet_d << 0 * 6);

        if (j < *output_length) decoded_data[j++] = (triple >> 2 * 8) & 0xFF;
        if (j < *output_length) decoded_data[j++] = (triple >> 1 * 8) & 0xFF;
        if (j < *output_length) decoded_data[j++] = (triple >> 0 * 8) & 0xFF;
    }

    decoded_data[*output_length] = '\0';
    return decoded_data;
}

int main() {
    const char *text = "Hello, World!";
    size_t text_length = strlen(text);

    // Mã hoá van b?n
    char *encoded_text = base64_encode((const unsigned char *)text, text_length);
    printf("Encoded: %s\n", encoded_text);

    // Gi?i mã van b?n
    size_t decoded_length;
    unsigned char *decoded_text = base64_decode(encoded_text, strlen(encoded_text), &decoded_length);
    printf("Decoded: %s\n", decoded_text);

    // Gi?i phóng b? nh?
    free(encoded_text);
    free(decoded_text);

    return 0;
}

