// __asm { VMOV.I32        Q8, #0 }
// v12 = (const char *)v7;
// _R0 = &v27;
// v14 = 0;
// __asm { VST1.64         {D16-D17}, [R0] }
// _R0 = &v26;
// __asm { VST1.64         {D16-D17}, [R0] }
// _R0 = &v25;
// __asm
// {
//   VST1.64         {D16-D17}, [R0]!
//   VST1.64         {D16-D17}, [R0]
// }
// v28 = 0;
// sub_22ED8((int)&v25);
// v17 = strlen(&v25);
// CCHmacInit(&v24, 2, &v25, v17);




//   /////



// r7 = sp + 0xc;
// asm{ bfc        r4, #0x0, #0x3 };
// sp = sp - 0x230;

// ---

//  asm{ vmov.i32   q8, #0x0 };
//     r6 = sp + 0x188;
//     r5 = r0;
//     r0 = r6 + 0x30;
//     r4 = 0x0;
//     asm{ vst1.64    {d16, d17}, [r0] };
//     r0 = r6 + 0x20;
//     asm{ vst1.64    {d16, d17}, [r0] };
//     r0 = r6;
//     asm{ vst1.64    {d16, d17}, [r0]! };
//     asm{ vst1.64    {d16, d17}, [r0] };
//     arg_1A8 = r4;
//     r0 = sub_22ed8(r6);
//     r0 = strlen(r6);
//     r0 = CCHmacInit(sp + 0x8, 0x2, r6, r0);

#include <stdio.h>

#include <string.h>
// void sub_22ed8(int arg0) {

//     r0 = arg0;
//     r1 = 0x0;

//     r2 = '\x86\xD6\xD6\xC2\x8B\xF3\xEA\xF0`\xF3~\x89\xD6\xF0~\xC2\xC2\xF0\xEA\xC2\x89\xD6\xD2\x8B~~\x8C\xF0\x8C\xC2\xC2\xEA\x92\xEA\x8C\xC2\x86\xF0l\xD6\xD2\x92l\xD6`\xF3\xD6\xEA\x8C\x86l\x86\x89\x8B\xD6l\xF0\xC2\xD2\x89~\x8B\xC2\xF0';
//     do {
//             r4 = *(r2 + r1);
//             *(r0 + r1) = r4;
//             if (r4 <= 0xc1) {
//                     if (r4 <= 0x85) {
//                             if (r4 != 0x60) {
//                                     if (r4 != 0x6c) {
//                                             if (r4 == 0x7e) {
//                                                     *(r0 + r1) = 0x63;
//                                             }
//                                     }
//                                     else {
//                                             *(r0 + r1) = 0x37;
//                                     }
//                             }
//                             else {
//                                     *(r0 + r1) = 0x33;
//                             }
//                     }
//                     else {
//                             switch (r0) {
//                                 case 0:
//                                     *(r0 + r1) = 0x34;
//                                     break;
//                                 case 1:
//                                     break;
//                                 case 2:
//                                     *(r0 + r1) = 0x31;
//                                     break;
//                                 case 3:
//                                     *(r0 + r1) = 0x36;
//                                     break;
//                                 case 4:
//                                     *(r0 + r1) = 0x61;
//                                     break;
//                                 default:
//                                     if (r4 == 0x86) {
//                                             r4 = 0x65;
//                                     }
//                                     if (CPU_FLAGS & E) {
//                                             *(r0 + r1) = r4;
//                                     }

//                             }
//                     }
//             }
//             else {
//                     if (r4 <= 0xe9) {
//                             if (r4 != 0xc2) {
//                                     if (r4 != 0xd2) {
//                                             if (r4 == 0xd6) {
//                                                     *(r0 + r1) = 0x62;
//                                             }
//                                     }
//                                     else {
//                                             *(r0 + r1) = 0x35;
//                                     }
//                             }
//                             else {
//                                     *(r0 + r1) = 0x66;
//                             }
//                     }
//                     else {
//                             if (r4 != 0xea) {
//                                     if (r4 != 0xf0) {
//                                             if (r4 == 0xf3) {
//                                                     *(r0 + r1) = 0x39;
//                                             }
//                                     }
//                                     else {
//                                             *(r0 + r1) = 0x32;
//                                     }
//                             }
//                             else {
//                                     *(r0 + r1) = 0x64;
//                             }
//                     }
//             }
//             r1 = r1 + 0x1;
//     } while (r1 != 0x40);

//     printf ("%d", r0);
//     return;
// }



void sub_22ED8()
{
  int v1; // r1@1
  int result[64];
  signed int v2; // r4@2

   // "\x86\xD6\xD6\xC2\x8B\xF3\xEA\xF0`\xF3~\x89\xD6\xF0~\xC2\xC2\xF0\xEA\xC2\x89\xD6\xD2\x8B~~\x8C\xF0\x8C\xC2\xC2\xEA\x92\xEA\x8C\xC2\x86\xF0l\xD6\xD2\x92l\xD6`\xF3\xD6\xEA\x8C\x86l\x86\x89\x8B\xD6l\xF0\xC2\xD2\x89~\x8B\xC2\xF0"
  char * aJLIILMMTMJLTlM = "ЖггTЛєъЁ`є~ЙгЁ~TTЁъTЙгTЛ~~МЁМTTъТъМTЖЁlгTТlг`єгъМЖlЖЙЛгlЁTTЙ~ЛTЁ";  //--> 64
  //                        ЖггTЛєъЁ`є~ЙгЁ~TTЁъTЙгTЛ~~МЁМTTъТъМTЖЁl  --> 39
  //                        ЖггTЛєъЁ3єcЙгЁcTTЁъTЙгTЛccМЁМTTъТъМTЖЁ7

  // printf("%d", aJLIILMMTMJLTlM[64]);
  v1 = 0;
  do
  {
  
    //(unsigned __int8)
    v2 = (unsigned int)aJLIILMMTMJLTlM[v1];
    printf ("%d ",  v2);
    // printf("%lu\n", strlen (aJLIILMMTMJLTlM));
 

    result[v1]  = v2;
     //printf ("res->   %d\n", result[v1]);
    
    if ( v2 > 193 )
    {
      if ( v2 > 233 )
      {
        switch ( v2 )
        {
          case 234:
            result[v1] = 100;
            break;
          case 240:
            result[v1] = 50;
            break;
          case 243:
            result[v1] = 57;
            break;
        }
      }
      else
      {
        switch ( v2 )
        {
          case 194:
            result[v1] = 102;
            break;
          case 210:
            result[v1] = 53;
            break;
          case 214:
            result[v1] = 98;
            break;
        }
      }
    }
    else if ( v2 > 133 )
    {
      switch ( v2 )
      {
        case 137:
          result[v1] = 52;
          break;
        case 139:
          result[v1] = 49;
          break;
        case 140:
          result[v1] = 54;
          break;
        case 146:
          result[v1] = 97;
          break;
        case 138:
        case 141:
        case 142:
        case 143:
        case 144:
        case 145:
          break;
        default:
          if ( v2 == 134 )
            result[v1] = 101;
          break;
      }
    }
    else
    {
      switch ( v2 )
      {
        case 96:
          result[v1] = 51;
          break;
        case 108:
          result[v1] = 55;
          break;
        case 126:
          result[v1] = 99;
          break;
      }
    }
    ++v1;
    //printf("v1= %d\n", v1 );
    
  }
  while ( v1 != 64 );
   


printf("\n------\n");

for(int j = 0; j < 64; j++) {



        printf("%d ", result[j]);
    
    }

    

 




   // printf("%s\n", result);
}
 

 int main(){


 int v4; // r0@1
  void *v5; // r8@1
  void *v6; // r0@1
  const char *v7; // r0@1
  const char *v12; // r5@1
  int v14; // r4@1
  size_t v17; // r0@1
  size_t v18; // r0@1
  char *v19; // r6@1
  int v20; // ST04_4@2
  void *v21; // r0@3
  int v22; // r5@3
  char v24; // [sp+8h] [bp-240h]@1
  char v25; // [sp+188h] [bp-C0h]@1
  int v26; // [sp+1A8h] [bp-A0h]@1
  int v27; // [sp+1B8h] [bp-90h]@1
  char v28; // [sp+1C8h] [bp-80h]@1
  char v29; // [sp+1CBh] [bp-7Dh]@1
  char v30[32]; // [sp+20Ch] [bp-3Ch]@1
  int v31; // [sp+22Ch] [bp-1Ch]@1

 //   char * _R0 = &v25;
 // _R0 = 0;




    // __asm { VMOV.I32        Q8, #0 }
    // v12 = v7;
    // _R0 = &v27;
    // v14 = 0;
    // __asm { VST1.64         {D16-D17}, [R0] }
    // _R0 = &v26;
    // __asm { VST1.64         {D16-D17}, [R0] }
    // _R0 = &v25;
    // __asm
    // {
    // VST1.64         {D16-D17}, [R0]!
    // VST1.64         {D16-D17}, [R0]
    // }
    // v28 = 0;




    // The 128-bit register Q8 is an alias for 2 consecutive 64-bit registers D16 and D17 but does not have an alias 
    // using the 32
    // vmov.i32 q8, #0          \n\t"  //clear our accumulator register
    // @ CHECK: vst1.64 {d16, d17}, [r0]       @ encoding: [0xcf,0x0a,0x40,0xf4]
 
    sub_22ED8();
    // v17 = sizeof(v25);

    // printf("--->%p", &v25 );
    // printf("--->%lu", v17);

    /////
   //   uint8_t myu[4] = {0xff, 0x068, 0xc5, 0x8f};
   //   int i, sz = sizeof(myu) / sizeof(myu[0]);
   //   char res[2 * sz + 1];

   // for (i = 0; i < sz; i++) {
   //  sprintf(res + 2 * i, "%02x", myu[i]);
   //   }

    return 0;
 }