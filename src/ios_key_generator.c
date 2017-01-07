 
#include <stdio.h>
 

int main()
{

// input hex value
// 86 D6 D6 C2 8B F3 EA F0  60 F3 7E 89 D6 F0 7E C2
// C2 F0 EA C2 89 D6 D2 8B  7E 7E 8C F0 8C C2 C2 EA
// 92 EA 8C C2 86 F0 6C D6  D2 92 6C D6 60 F3 D6 EA
// 8C 86 6C 86 89 8B D6 6C  F0 C2 D2 89 7E 8B C2 F0
// 00
 
	// char *hex_str = "86D6D6C28BF3EAF060F37E89D6F07EC2C2F0EAC289D6D28B7E7E8CF08CC2C2EA92EA8CC286F06CD6D2926CD660F3D6EA8C866C86898BD66CF0C2D2897E8BC2F0";
	// instagram 9.6
	char *hex_str =    "86D6C2D68B8BF3EAF0608B7E89D2C2D28C929292EA8BF0606CD292B16C7E8C8CC28CEA6CF36CEA866C8BF086B1C56CC289C586B1C2F3EA7E8CF3898B7E6C8CD2";
	unsigned int intVal;
	int s = 0;
	int v2;
	int v1;
	for(int j = 0; j < 128; j = j + 2) {

		char buffer [50];
		sprintf (buffer, "%c%c", hex_str[j], hex_str[j+1]);
		sscanf(buffer, "%x", &intVal);

#ifdef DEBUG
		printf("input hex: %x - %d ", intVal, intVal);
#endif

		v2  = intVal;

		 

		if ( v2 > 176 )
    {
      if ( v2 > 213 )
      {
        if ( v2 > 239 )
        {
          if ( v2 == 240 )
          {
            v1 = 98;
          }
          else if ( v2 == 243 )
          {
            v1 = 49;
          }
        }
        else if ( v2 == 214 )
        {
          v1 = 102;
        }
        else if ( v2 == 234 )
        {
          v1 = 101;
        }
      }
      else if ( v2 > 196 )
      {
        if ( v2 == 197 )
        {
          v1 = 55;
        }
        else if ( v2 == 210 )
        {
          v1 = 56;
        }
      }
      else if ( v2 == 177 )
      {
        v1 = 99;
      }
      else if ( v2 == 194 )
      {
        v1 = 100;
      }
    }
    else if ( v2 > 133 )
    {
      switch ( v2 )
      {
        case 137:
          v1 = 52;
          break;
        case 139:
          v1 = 48;
          break;
        case 140:
          v1 = 97;
          break;
        case 146:
          v1 = 54;
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
            v1 = 51;
          break;
      }
    }
    else
    {
      switch ( v2 )
      {
        case 96:
          v1 = 53;
          break;
        case 108:
          v1 = 57;
          break;
        case 126:
          v1 = 50;
          break;
      }
    }



///////////////////////////////////




		    // if ( v2 > 193 )
		    // {
		    //   if ( v2 > 233 )
		    //   {
		    //     switch ( v2 )
		    //     {
		    //       case 234:
		    //         v1 = 100;
		    //         break;
		    //       case 240:
		    //         v1 = 50;
		    //         break;
		    //       case 243:
		    //         v1 = 57;
		    //         break;
		    //     }
		    //   }
		    //   else
		    //   {
		    //     switch ( v2 )
		    //     {
		    //       case 194:
		    //         v1 = 102;
		    //         break;
		    //       case 210:
		    //         v1 = 53;
		    //         break;
		    //       case 214:
		    //         v1 = 98;
		    //         break;
		    //     }
		    //   }
		    // }
		    // else if ( v2 > 133 )
		    // {
		    //   switch ( v2 )
		    //   {
		    //     case 137:
		    //       v1 = 52;
		    //       break;
		    //     case 139:
		    //       v1 = 49;
		    //       break;
		    //     case 140:
		    //       v1 = 54;
		    //       break;
		    //     case 146:
		    //       v1 = 97;
		    //       break;
		    //     case 138:
		    //     case 141:
		    //     case 142:
		    //     case 143:
		    //     case 144:
		    //     case 145:
		    //       break;
		    //     default:
		    //       if ( v2 == 134 )
		    //         v1 = 101;
		    //       break;
		    //   }
		    // }
		    // else
		    // {
		    //   switch ( v2 )
		    //   {
		    //     case 96:
		    //       v1 = 51;
		    //       break;
		    //     case 108:
		    //       v1 = 55;
		    //       break;
		    //     case 126:
		    //       v1 = 99;
		    //       break;
		    //   }
		    // }

		
#ifdef DEBUG
		  printf("-> %d", v1);
		  printf(" %c\n", (char)v1);
#else
		  printf("%c", (char)v1);
#endif

		s++;
		 
    }
    // printf("%d\n", s);

    return 0;
}


