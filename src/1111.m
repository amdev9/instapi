

#import <objc/objc.h>
#import <objc/Object.h>
#import <Foundation/Foundation.h>
 
// "4749bda4fc1f49372dae3d79db339ce4959cfbbe"
// 9.5.2
// "\x86\xD6\xD6\xC2\x8B\xF3\xEA\xF0`\xF3~\x89\xD6\xF0~\xC2\xC2\xF0\xEA\xC2\x89\xD6\xD2\x8B~~\x8C\xF0\x8C\xC2\xC2\xEA\x92\xEA\x8C\xC2\x86\xF0l\xD6\xD2\x92l\xD6`\xF3\xD6\xEA\x8C\x86l\x86\x89\x8B\xD6l\xF0\xC2\xD2\x89~\x8B\xC2\xF0", 0 ; XREF=sub_22ed8+8, sub_22ed8+14, sub_22ed8+22
 
int main (int argc, const char * argv[])
{
   NSAutoreleasePool * pool = [[NSAutoreleasePool alloc] init];
sub_57ea20();
   //NSLog (@"hello world");
   [pool drain];
 
   return 0;
}
 
 
int sub_57ea20() {
    char r4;
    char * r11;
    char * r0 = "4749bda4fc1f49372dae3d79db339ce4959cfbbe";
    char r1 = 0x0;
    char * salt = "\xB1;\xF4\xB8\xAD;\xB1\xBB\xF4\r\xAD\xB8\r|\r|Y\xB8\x9F\xADsj\xB8\x9F\xF4\xBB\xB2\xB3Y\xB2|\xB8\rj\xF4\xB8\xB1\xBB\xB2;\xAD|s\xBB\xD8\xB3|Y\xB1\xB8\xF4|\xB3Y\xAD\x9F\xD8\xAD\xD8Yj\xF4Y\xB2";
 
    goto reset;
 
reset:
 
    r11 = *(salt + r1);
    *(r0 + r1) = r11;
    //r0 = r11;
 
    if (r11 > 0x9e) goto step1;
 
loc_57ea5a:
    if (r11 > 0x58) goto loc_57ea80;
 
loc_57ea60:
    if (r11 == 0xd) {
            r0 = 0x64;
    }
    else {
            if (r11 == 0x3b) {
                    r0 = 0x35;
            }
 
}    goto loc_57eb0a;
 
loc_57eb0a:
    r1 = r1 + 0x1;
    printf("step: %#04x\n", r1);
    if (r1 != 0x40) goto reset;
 
printf("%#040x\n", r11);
return 0;
 
 
loc_57ea80:
    if (r11 > 0x72) goto loc_57eaca;
 
loc_57ea86:
    if (r11 != 0x59) goto loc_57eae2;
 
loc_57ea8c:
    r0 = 0x39;
    goto loc_57eb0a;
 
loc_57eae2:
    if (r11 != 0x6a) goto loc_57eb0a;
 
loc_57eae8:
    r4 = 0x61;
    goto loc_57eb08;
 
loc_57eb08:
    r0 = r4;
    goto loc_57eb0a;
 
loc_57eaca:
    if (r11 != 0x73) goto loc_57eaec;
 
loc_57ead0:
    r0 = 0x66;
    goto loc_57eb0a;
 
loc_57eaec:
    if (r11 != 0x7c) goto loc_57eb0a;
 
loc_57eaf2:
    r4 = 0x34;
    goto loc_57eb08;
 
step1:
    if (r11 > 0xd7) goto loc_57ea92;
 
loc_57ea70:
    if (r11 > 0xac) goto loc_57eaaa;
 
loc_57ea76:
    if (r11 == 0x9f) {
            r0 = 0x33;
    }
    goto loc_57eb0a;
 
loc_57eaaa:
    if (r11 > 0xbb) goto loc_57eb0a;
 
loc_57eab2:
    printf("so sad");
    goto *0x57eab6[r0];
 
loc_57eac6:
    r4 = 0x62;
    goto loc_57eb08;
 
loc_57eaf6:
    r4 = 0x65;
    goto loc_57eb08;
 
loc_57eafa:
    r4 = 0x37;
    goto loc_57eb08;
 
loc_57eafe:
    r4 = 0x31;
    goto loc_57eb08;
 
loc_57eb02:
    r4 = 0x32;
    goto loc_57eb08;
 
loc_57eb06:
    r4 = 0x30;
    goto loc_57eb08;
 
loc_57ea92:
    if (r11 == 0xf4) {
            r0 = 0x36;
    }
    else {
            if (r11 == 0xd8) {
                    r0 = 0x38;
            }
    }
    goto loc_57eb0a;
 
}

