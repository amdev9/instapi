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



int sub_22ED8(int result)
{
  int v1; // r1@1
  signed int v2; // r4@2
  char * aJLIILMMTMJLTlM = "ЖггTЛєъЁ`є~ЙгЁ~TTЁъTЙгTЛ~~МЁМTTъТъМTЖЁlгTТlг`єгъМЖlЖЙЛгlЁTTЙ~ЛTЁ";
  // printf("%d", aJLIILMMTMJLTlM[64]);
  v1 = 0;
  do
  {
  
    //(unsigned __int8)
    v2 = (unsigned int)aJLIILMMTMJLTlM[v1];
    printf ("-> %d\n", v2);


    result  = v2 - v1;
    
    if ( v2 > 193 )
    {
      if ( v2 > 233 )
      {
        switch ( v2 )
        {
          case 234:
            result  = 100 - v1;
            break;
          case 240:
            result  = 50 - v1;
            break;
          case 243:
            result = 57 - v1;
            break;
        }
      }
      else
      {
        switch ( v2 )
        {
          case 194:
            result  = 102 - v1;
            break;
          case 210:
            result  = 53 - v1;
            break;
          case 214:
            result  = 98 -  v1;
            break;
        }
      }
    }
    else if ( v2 > 133 )
    {
      switch ( v2 )
      {
        case 137:
          result = 52 -v1;
          break;
        case 139:
          result = 49-v1;
          break;
        case 140:
          result = 54-v1;
          break;
        case 146:
          result = 97-v1;
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
            result = 101-v1;
          break;
      }
    }
    else
    {
      switch ( v2 )
      {
        case 96:
          result = 51-v1;
          break;
        case 108:
          result = 55-v1;
          break;
        case 126:
          result = 99-v1;
          break;
      }
    }
    ++v1;
    printf("v1= %d\n", v1 );
     printf ("res->   %d\n", result);
  }
  while ( v1 != 64 );
  return result;
}
 

 int main(){
    int res;
    char v25;// = 'a';
    size_t siz;
    sub_22ED8( (int)&v25 );


    printf("--->%s", &v25 );
    printf("--->%lu", strlen(&v25) );
    return 0;
 }