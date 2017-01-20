#include <SoftwareSerial.h>
#include <String.h>

const int temp_pin = 0;
const int white = 2;
const int blue = 3;
const int red = 5;
const int green = 4;
const int fan = 9;

int blue_status = 0;
int white_status = 0;
int red_status = 0;
int green_status = 0;

int timer = 0;
int countdown = 0;

float current_temp;

String temp_sensor;
String tension;
String light_sensor;
String mesure;
String a_status;
String b_status;

String command;


SoftwareSerial rpiSerial(10, 11);
//Serial(0, 1);

void setup() {
    pinMode(10, INPUT);
    pinMode(0, INPUT);
    pinMode(11, OUTPUT);
    pinMode(1, OUTPUT);
    pinMode(blue, OUTPUT);

    pinMode(white, OUTPUT);

    pinMode(red, OUTPUT);
    pinMode(green, OUTPUT);
    pinMode(fan, OUTPUT);

    rpiSerial.begin(115200);
    rpiSerial.println("Serial Lya Connection Started");
    Serial.begin(115200);
}

void loop() {

    digitalWrite(white, HIGH);

    current_temp = getTemp(temp_pin);

    while (Serial.available() > 0) {
        char inByte = Serial.read();

        rpiSerial.print(inByte);

        if (inByte == 't') {
            rpiSerial.println("");
            rpiSerial.print(current_temp);
            rpiSerial.print('c');
        }

        if (inByte == 'b') {
            rpiSerial.println("");
            rpiSerial.print(white_status);
            rpiSerial.println("w");
            rpiSerial.print(blue_status);
            rpiSerial.println("u");
            rpiSerial.print(green_status);
            rpiSerial.println("g");
            rpiSerial.print(red_status);
            rpiSerial.println("r");
        }
    }

   while (rpiSerial.available() > 0) {
        char inByte = rpiSerial.read();
       Serial.print(inByte);
            if (inByte == '4') {
                if (blue_status == 0) {
                    blue_status = 1;
                } else {
                    blue_status = 0;
                }
            } else if (inByte == '5') {
                if (white_status == 0) {
                    white_status = 1;
                } else {
                    white_status = 0;
                }
            } else if (inByte == '6') {
                if (red_status == 0) {
                    red_status = 1;
                } else {
                    red_status = 0;
                }
            } else if (inByte == '7') {
                if (green_status == 0) {
                    green_status = 1;
                } else {
                    green_status = 0;
                }
            }
    }

    if (current_temp > 40.0) {
        digitalWrite(fan, HIGH);
        countdown = 11;
    }

    if (countdown == 1) {
        digitalWrite(fan, LOW);
    }

    if (blue_status == 1) {
        digitalWrite(blue, HIGH);
    } else {
        digitalWrite(blue, LOW);
    }

    if (white_status == 1) {
        digitalWrite(white, HIGH);
    } else {
        digitalWrite(white, LOW);
    }

    if (red_status == 1) {
        digitalWrite(red, HIGH);
    } else {
        digitalWrite(red, LOW);
    }

    if (green_status == 1) {
        digitalWrite(green, HIGH);
    } else {
        digitalWrite(green, LOW);
    }

    if (b_status == "1" && timer % 2 == 0) {
        red_status = 1;
    } else if (b_status == "1" && timer % 2 != 0){
        red_status = 0;
    }

    if (countdown != 0 && timer % 2 == 0) {
        countdown--;
    }

        timer++;
        delay(500);
}

float getTemp(int temp_pin) {
    int valeur_brute = analogRead(temp_pin);
    return valeur_brute * (5.0 / 1023.0 * 100.0);
}