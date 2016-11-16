#include <stdio.h>
#include <stdlib.h>
int main()
{ 
     // char *p;
     // int a;
     // p = (int *)malloc(sizeof(int));
     // *p = 10;
     // a = (int)p;
     // printf("%p\n", p);
     // printf("%d \n",a);



	 int result[64];

	  int v1 = 0;
	   result[v1]  = 10;


	   printf("%d\n", result[v1]);



	   //  char str[11];
    // sprintf(str, "%d",  126);
    // printf("%s ",str);



// 9.6

// 86 D6 C2 D6 8B 8B F3 EA  F0 60 8B 7E 89 D2 C2 D2
// 8C 92 92 92 EA 8B F0 60  6C D2 92 B1 6C 7E 8C 8C
// C2 8C EA 6C F3 6C EA 86  6C 8B F0 86 B1 C5 6C C2
// 89 C5 86 B1 C2 F3 EA 7E  8C F3 89 8B 7E 6C 8C D2


// int __fastcall sub_23448(int result)
// {
//   int v1; // r1@1
//   signed int v2; // r6@2

//   v1 = 0;
//   do
//   {
//     v2 = (unsigned __int8)aJLlLIMtttLLTLM[v1];
//     *(_BYTE *)(result + v1) = v2;
//     if ( v2 > 176 )
//     {
//       if ( v2 > 213 )
//       {
//         if ( v2 > 239 )
//         {
//           if ( v2 == 240 )
//           {
//             *(_BYTE *)(result + v1) = 98;
//           }
//           else if ( v2 == 243 )
//           {
//             *(_BYTE *)(result + v1) = 49;
//           }
//         }
//         else if ( v2 == 214 )
//         {
//           *(_BYTE *)(result + v1) = 102;
//         }
//         else if ( v2 == 234 )
//         {
//           *(_BYTE *)(result + v1) = 101;
//         }
//       }
//       else if ( v2 > 196 )
//       {
//         if ( v2 == 197 )
//         {
//           *(_BYTE *)(result + v1) = 55;
//         }
//         else if ( v2 == 210 )
//         {
//           *(_BYTE *)(result + v1) = 56;
//         }
//       }
//       else if ( v2 == 177 )
//       {
//         *(_BYTE *)(result + v1) = 99;
//       }
//       else if ( v2 == 194 )
//       {
//         *(_BYTE *)(result + v1) = 100;
//       }
//     }
//     else if ( v2 > 133 )
//     {
//       switch ( v2 )
//       {
//         case 137:
//           *(_BYTE *)(result + v1) = 52;
//           break;
//         case 139:
//           *(_BYTE *)(result + v1) = 48;
//           break;
//         case 140:
//           *(_BYTE *)(result + v1) = 97;
//           break;
//         case 146:
//           *(_BYTE *)(result + v1) = 54;
//           break;
//         case 138:
//         case 141:
//         case 142:
//         case 143:
//         case 144:
//         case 145:
//           break;
//         default:
//           if ( v2 == 134 )
//             *(_BYTE *)(result + v1) = 51;
//           break;
//       }
//     }
//     else
//     {
//       switch ( v2 )
//       {
//         case 96:
//           *(_BYTE *)(result + v1) = 53;
//           break;
//         case 108:
//           *(_BYTE *)(result + v1) = 57;
//           break;
//         case 126:
//           *(_BYTE *)(result + v1) = 50;
//           break;
//       }
//     }
//     ++v1;
//   }
//   while ( v1 != 64 );
//   return result;
// }


     return 0;
}

 
