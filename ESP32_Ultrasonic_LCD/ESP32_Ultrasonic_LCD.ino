/*
 * This ESP32 code is created by esp32io.com
 
 */

#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 16, 2); // I2C address 0x3F, 16 column and 2 rows

#define TRIG_PIN 5 // ESP32 pin GIOP5 connected to Ultrasonic Sensor's TRIG pin
#define ECHO_PIN 18 // ESP32 pin GIOP18 connected to Ultrasonic Sensor's ECHO pin

float duration_us, distance;

void setup() {
  lcd.init();               // initialize the lcd
  lcd.backlight();          // open the backlight
  pinMode(TRIG_PIN, OUTPUT); // config trigger pin to output mode
  pinMode(ECHO_PIN, INPUT);  // config echo pin to input mode
}

void loop() {
  // generate 10-microsecond pulse to TRIG pin
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  // measure duration of pulse from ECHO pin
  duration_us = pulseIn(ECHO_PIN, HIGH);

  // calculate the distance
  distance = 0.017 * duration_us;

  lcd.clear();
  lcd.setCursor(0, 0); // start to print at the first row
  lcd.print("Tank 1 Monitor ");
  lcd.setCursor(0, 1); // start to print at the first row
  lcd.print("Level: ");
  lcd.print(distance);
  //lcd.print("cm");
  delay(500);
}